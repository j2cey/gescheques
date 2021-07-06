<?php


namespace App\Traits\BordereauremiseFile;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Bordereauremise;
use App\Models\BordereauremiseLoc;
use App\Models\BordereauremiseType;
use App\Models\BordereauremiseLigne;
use App\Models\BordereauremiseModepaie;

trait ImportFileTrait
{
    public function import($nb_lines_to_process) {

        $pendingfiles_dir = config('app.bordereauremises_filesscanned');
        $raw_dir = config('app.RAW_FOLDER');
        $file_fullpath = $pendingfiles_dir.'/'.$this->name;

        $csvData = file_get_contents($raw_dir.'/'.$file_fullpath);
        $rows = array_map("str_getcsv", explode("\n", $csvData));

        $rows_processed = 0;
        for ($i = 0; $i < $this->nb_rows; $i++) {
            $row_current = $i + 1;
            $row = $rows[$i];

            $can_process_line = ($row_current > $this->row_last_processed);
            if ($can_process_line) {

                $this->nb_rows_processing += 1;
                $this->save();

                // récuration des paramètres de la ligne
                $row_parsed = $this->getParameters($row);

                if ($row_parsed[0]) {
                    //['date_remise','numero_transaction','localisation_code','localisation_titre','classe_paiement','mode_paiement','montant_total']
                    $localisation = $this->getLocalisation($row_parsed[1]['localisation_code'],$row_parsed[1]['localisation_titre']);
                    $modepaie = $this->getModepaiement($row_parsed[1]['mode_paiement']);

                    $bordereau = $this->getBordereau($row_parsed[1],$localisation,$modepaie);
                    $ligne_bordereau = $this->getBordereauLigne($row_parsed[1], $bordereau);

                    $this->nb_rows_success += 1;
                } else {
                    $this->nb_rows_failed += 1;
                }

                $this->nb_rows_processing -= 1;
                $this->nb_rows_processed += 1;

                $this->save();

                // MAJ du SmscampaingFile
                $this->row_last_processed = $row_current;
                $rows_processed++;
                $this->imported = ($this->nb_rows_processed === $this->nb_rows);
                if ($rows_processed === $nb_lines_to_process) {
                    break;
                }
            }
        }
        $this->nb_try += 1;
        // unmark as processing
        $this->import_processing = 0;
        //$this->imported = ($this->nb_rows_processed >= $this->nb_rows ? 1 : 0);
        $this->save();
    }

    private function getBordereau($row, $localisation, $modepaie) {
        // TODO: Créer le scope coded pour les types de bordereau
        if ( empty($row['reference_bank']) || $row['reference_bank'] === "" ) {
            // Type èspèce
            // On crée un nouveau bordereau a une ligne
            $type = BordereauremiseType::where('id', 1)->first();
            $bordereau = $this->createBordereau($row, $localisation, $modepaie, $type);
        } else {
            // Type chèque
            $type = BordereauremiseType::where('id', 2)->first();
            $bordereau = Bordereauremise::where('numero_transaction', $row['numero_transaction'])->first();
            if ($bordereau) {
                $bordereau->update([
                    'montant_total' => ($bordereau->montant_total + $row['montant_total']),
                ]);
            } else {
                $bordereau = $this->createBordereau($row, $localisation, $modepaie, $type);
            }
        }

        return $bordereau;
    }

    private function createBordereau($row, $localisation, $modepaie, $type) {
        return Bordereauremise::create([
            'date_remise' => Carbon::createFromFormat('d/m/Y', $row['date_remise'])->format('Y-m-d'),//date('Y-m-d',strtotime($row_parsed[1]['date_remise'])),
            'numero_transaction' => $row['numero_transaction'],
            'bordereauremise_type_id' => $type->id,
            'bordereauremise_type_titre' => $type->titre,
            'bordereauremise_loc_id' => $localisation->id,
            'localisation_titre' => $localisation->titre,
            'bordereauremise_modepaie_id' => $modepaie->id,
            'modepaiement_titre' => $modepaie->titre,
            'montant_total' => $row['montant_total'],
            'workflow_currentstep_titre' => "aucun traitement", // On assigne une valeur pour pas faire échouer le check isset
            'workflow_currentstep_code' => "aucun traitement", // On assigne une valeur pour pas faire échouer le check isset
        ]);
    }

    private function getBordereauLigne($row, $bordereau) {
        return BordereauremiseLigne::create([
            'bordereauremise_id' => $bordereau->id,
            'reference' => utf8_encode($row['reference_bank']),
            'classe_paiement' => utf8_encode($row['classe_paiement']),
            'montant' => $row['montant_total'],
        ]);
    }

    /**
     * @param $titre
     * @return BordereauremiseLoc|null
     */
    private function getLocalisation($code, $titre) {
        $localisation = BordereauremiseLoc::where('code', $code)->first();
        if (! $localisation) {
            $localisation = BordereauremiseLoc::create([
                'code' => $code,
                'titre' => utf8_encode($titre)
            ]);
        }
        return $localisation;
    }

    private function getModepaiement($titre) {
        $modepaie = BordereauremiseModepaie::where('titre', $titre)->first();
        if (! $modepaie) {
            $modepaie = BordereauremiseModepaie::create([
                'code' => Str::slug( (string) Str::orderedUuid() ),
                'titre' => utf8_encode($titre)
            ]);
        }
        return $modepaie;
    }

    private function getParameters($row) {
        // TODO: (1) Tester $row[0]; (2) Faire l'explode si la ligne est un string
        $sep = config('Settings.bordereaux_remise.fichier.separateur_colonnes');
        //$row_tab = $row; //explode(',', $row);
        $row_tab = explode($sep, $row[0]);
        // DatePaid;TrackingNumber;Location;LocationName;OSS360_PaymentType;BankName;Montant Total
        $row_tab_fields = ['date_remise','numero_transaction','localisation_code','localisation_titre','reference_bank','classe_paiement','mode_paiement','montant_total'];
        $row_tab_values = [];
        $key = 0;
        foreach ($row_tab as $value) {
            $row_tab_values[$row_tab_fields[$key]] = trim($value);
            $key++;
        }

        return [true, $row_tab_values];
    }
}
