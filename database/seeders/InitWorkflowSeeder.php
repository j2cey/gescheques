<?php

namespace Database\Seeders;

use App\Models\Workflow;
use App\Models\MimeType;
use App\Models\WorkflowStep;
use App\Models\WorkflowAction;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;
use App\Models\WorkflowActionType;

class InitWorkflowSeeder extends Seeder
{
    private Role $agencerole;
    private Role $financerole;
    private Role $dfrrole;

    private WorkflowActionType $date_type;
    private WorkflowActionType $string_type;
    private WorkflowActionType $boolean_type;
    private WorkflowActionType $file_type;
    private WorkflowActionType $enum_type;
    private Collection $mime_types_ids;

    private WorkflowStep $step_end;
    private WorkflowStep $step_rejected;
    private WorkflowStep $step_expired;

    public function __construct()
    {
        $this->agencerole = Role::where('name', 'Agences')->first();
        $this->financerole = Role::where('name', 'Division Finances')->first();
        $this->dfrrole = Role::where('name', 'DFR')->first();

        $this->date_type = WorkflowActionType::where('code', "DATETIME_value")->first();
        $this->string_type = WorkflowActionType::where('code', "STRING_value")->first();
        $this->boolean_type = WorkflowActionType::where('code', "BOOLEAN_value")->first();
        $this->file_type = WorkflowActionType::where('code', "FILE_ref")->first();
        $this->enum_type = WorkflowActionType::where('code', "EnumType")->first();
        $this->mime_types_ids = MimeType::defaultFileMimeTypes();

        // Traitement Terminé
        $this->step_end = WorkflowStep::createNew("Traitement Terminé", "Etape marquant la fin de tout Workflow", null,"step_end");
        // Traitement Rejeté
        $this->step_rejected = WorkflowStep::createNew("Traitement Rejeté", "Etape marquant le rejet de tout Workflow", null,"step_rejected");
        // Traitement Expiré
        $this->step_expired = WorkflowStep::createNew("Traitement Expiré", "Etape marquant l expiration de tout Workflow", null,"step_expired");
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $motif_rejet_action = WorkflowAction::createRejectionAction("Motif Rejet", "Motif Rejet", null, $this->string_type,"motif_rejet_action");
        $this->step_rejected->addAction($motif_rejet_action, true);

        // Traitement Chèque impayés
        $traitement_cheque_impayes_wf = $this->createWorkflow("Traitement Chèque impayés","Processus de Traitement des Chèques impayés",1,2,"App\Models\Cheque");

        // Etap 1: Traitement Finances
        $step_finances = $this->create_step_finances($traitement_cheque_impayes_wf)
            ->setNextStepAfterRejected($this->step_end, true);
        ;
        // ajout d un motif de rejet
        $step_finances->addMotifRejet(true, "Veuillez spécifier le motif");
        //
        $step_finances->addValidationAction("Commentaire (Finances)", "Commentaire (Finances)",$this->string_type);
        //
        $step_finances->addValidationFileAction("Scan Cheque", "Scan Cheque");
        //
        $step_finances->setNextStepAfterRejected($this->step_end, true);

        // Réception Agences
        $step_reception_agences = $this->create_step_reception_agences($traitement_cheque_impayes_wf);
        //
        $step_reception_agences->addValidationAction("Commentaire (Agences)", "Commentaire (Agences)",$this->string_type);
        //
        $step_reception_agences->addMotifRejet(true, "Veuillez spécifier le motif");

        // Relance Client
        $step_relance_client = $this->create_step_relance_client($traitement_cheque_impayes_wf)
            ->setSetpParent($step_reception_agences, true)
        ;
        $step_relance_client->addValidationAction("Commentaire", "Commentaire (Relance Client)",$this->string_type);
        $step_relance_client->addRejectionEnumTypeAction("Motif Réjet Agences", [
            ["Indisponibilité","indisponibilité du client"], ["Refus","refus du client"],
        ], "Motif Réjet", "Motif Réjet (Relance Client)")
            ->setRequired(true,"Prière de préciser le Motif de réjet", true)
        ;
        $step_reception_agences->setNextStepAfterValidated($step_relance_client, true);

        $step_reouverture_facture = $this->create_step_reouverture_facture($traitement_cheque_impayes_wf)
            ->setSetpParent($step_reception_agences, true)
        ;
        $step_reouverture_facture->addValidationAction("Numéro facture", "Numéro facture", $this->string_type)
            ->setRequired(true,"Prière de renseigner le numéro de facture", true)
        ;
        $step_reouverture_facture->addMotifRejet(true, "Veuillez spécifier le motif");
        $step_relance_client->setNextStepAfterValidated($step_reouverture_facture, true);

        // Encaissement Facture
        $step_encaissement_facture = $this->create_step_encaissement_facture($traitement_cheque_impayes_wf)
            ->setSetpParent($step_reception_agences, true)
        ;
        $step_encaissement_facture->addValidationAction("Montant encaissé", "Montant encaissé", $this->string_type)
            ->setRequired(true,"Prière de renseigner le Montant", true)
        ;
        $step_encaissement_facture->addMotifRejet(true, "Veuillez spécifier le motif");
        $step_reouverture_facture->setNextStepAfterValidated($step_encaissement_facture, true);

        $step_finance_compta = $this->create_step_finance_compta($traitement_cheque_impayes_wf)
            ->setSetpParent($step_reception_agences, true)
            ->setNextStepAfterRejected($this->step_end, true)
            ->setNextStepAfterValidated($this->step_end, true)
        ;
        $step_finance_compta->addValidationAction("Commentaire", "Commentaire (Compta)",$this->string_type);
        $step_finance_compta->addMotifRejet(true, "Veuillez spécifier le motif");
        $step_encaissement_facture->setNextStepAfterValidated($step_finance_compta, true);

        $step_dfr = $this->create_step_dfr($traitement_cheque_impayes_wf)
            ->setNextStepAfterRejected($this->step_end, true)
        ;
        $step_dfr->addValidationAction("Commentaire", "Commentaire (DFR)",$this->string_type);
        $step_dfr->addMotifRejet(true, "Veuillez spécifier le motif");

        $step_reception_agences->setNextStepAfterRejected($step_dfr, true);
        $step_relance_client->setNextStepAfterRejected($step_dfr, true);
        $step_reouverture_facture->setNextStepAfterRejected($step_dfr, true);
        $step_encaissement_facture->setNextStepAfterRejected($step_dfr, true);

        // Traitement Finances - validated_nextstep: Traitement Agences
        $step_finances->setNextStepAfterValidated($step_reception_agences, true);

        $step_dfr->setNextStepAfterValidated($step_reception_agences, true);
    }

    private function createWorkflow($titre, $description, $user_id, $workflow_object_id, $model_type) : Workflow {
        return Workflow::create([
            'titre' => $titre,
            'description' => $description,
            'user_id' => $user_id,
            'workflow_object_id' => $workflow_object_id,
            'model_type' => $model_type,
        ]);
    }

    private function create_step_finances($workflow) : WorkflowStep {
        return WorkflowStep::createNew("Réception Finances", "Réception & Enregistrement niveau Finances", $workflow)
            ->setProfileStatic(true, $this->financerole,true)
            ->setNextStepAfterRejected($this->step_end, true);
    }

    private function create_step_reception_agences($workflow) : WorkflowStep {
        return  WorkflowStep::createNew("Réception Agences", "Traitements niveau Agence", $workflow)
            ->setProfileDynamic(true,"Agence", "Agence Précédente", true)
            ;
    }

    private function create_step_relance_client($workflow) : WorkflowStep {
        return  WorkflowStep::createNew("Relance Client", "Traitements Relance Client (Agences)", $workflow)
            ->setProfilePrevious(true, true)
            ;
    }

    private function create_step_reouverture_facture($workflow) : WorkflowStep {
        return  WorkflowStep::createNew("Reouverture Facture", "Traitements Reouverture Facture (Agences)", $workflow)
            ->setProfilePrevious(true, true)
            ;
    }

    private function create_step_encaissement_facture($workflow) : WorkflowStep {
        return WorkflowStep::createNew("Encaissement Facture", "Encaissement Facture (Agences)", $workflow)
            ->setProfilePrevious(true, true)
            ;
    }

    private function create_step_finance_compta($workflow) : WorkflowStep {
        return WorkflowStep::createNew("Comptabilisation", "Comptabilisation après retraitement", $workflow)
            ->setProfileStatic(true, $this->financerole,true)
            ;
    }

    private function create_step_dfr($workflow) : WorkflowStep {
        return WorkflowStep::createNew("Traitement DFR", "Traitements niveau DFR", $workflow)
            ->setProfileStatic(true, $this->dfrrole,true)
            ;
    }
}
