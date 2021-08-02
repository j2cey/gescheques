<?php

namespace Database\Seeders;

use App\Models\MimeType;
use App\Models\EnumType;
use App\Models\EnumValue;
use App\Models\WorkflowStep;
use App\Models\WorkflowAction;
use Illuminate\Database\Seeder;
use App\Models\WorkflowActionType;

class WorkflowActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date_type = WorkflowActionType::where('code', "DATETIME_value")->first();
        $string_type = WorkflowActionType::where('code', "STRING_value")->first();
        $boolean_type = WorkflowActionType::where('code', "BOOLEAN_value")->first();
        $file_type = WorkflowActionType::where('code', "FILE_ref")->first();
        $enum_type = WorkflowActionType::where('code', "EnumType")->first();
        $mime_types_ids = MimeType::whereIn('extension', ['png','jpg','bmp','pdf'])->get()->pluck('id');

        // 0 - motif rejet
        $workflow_step = WorkflowStep::where('code', "step_rejected")->first();
        $motif_rejet_action = WorkflowAction::createNew("Motif Rejet", "Motif Rejet", null, "motif_rejet_action")
            ->setActionType($string_type, true)
            ->setRequired(false,null, true)
        ;
        $workflow_step->addRejectionAction($motif_rejet_action, true);

        // 1 - Step: Réception Finances
        $workflow_step = WorkflowStep::where('titre', "Réception Finances")->first();
        $workflow_step->addRejectionAction($motif_rejet_action, true);

        // 2 - commentaire_finance
        $action = WorkflowAction::createNew("Commentaire (Finances)", "Commentaire (Finances)")
            ->setActionType($string_type, true)
            ->setRequired(false,null, true)
        ;
        $workflow_step->addValidationAction($action, true);

        // 3 - scan_cheque
        $action = WorkflowAction::createNew("Scan Cheque", "Scan Cheque")
            ->setActionType($file_type, true)
            ->setRequired(false,null, true)
            ->setMimeTypes($mime_types_ids, true)
        ;
        $workflow_step->addValidationAction($action, true);

        // Réception Agences
        $workflow_step = WorkflowStep::where('titre', "Réception Agences")->first();

        // 5 - Commentaire Agences
        $action = WorkflowAction::createNew("Commentaire (Agences)", "Commentaire (Agences)")
            ->setActionType($string_type, true)
            ->setRequired(false,null, true)
        ;
        $workflow_step->addValidationAction($action, true);
        $workflow_step->addRejectionAction($motif_rejet_action, true);

        // Relance Client
        $workflow_step = WorkflowStep::where('titre', "Relance Client")->first();

        $action = WorkflowAction::createNew("Commentaire", "Commentaire (Relance Client)")
            ->setActionType($string_type, true)
            ->setRequired(false,null, true)
        ;
        $workflow_step->addValidationAction($action, true);

        $motif_rejet_agence_enumtype = EnumType::createNew("Motif Réjet Agences")
            ->addValues([
                ["Indisponibilité","indisponibilité du client"],
                ["Refus","refus du client"],
            ])
        ;

        $action = WorkflowAction::createNew("Motif Réjet", "Motif Réjet (Agences)")
            ->setActionType($enum_type, true)
            ->setRequired(true,"Prière de préciser le Motif de réjet", true)
            ->setDedicatedForm("rejection", true)
            ->setEnumType($motif_rejet_agence_enumtype, true)
        ;
        $workflow_step->addRejectionAction($action, true);

        // Reouverture Facture
        $workflow_step = WorkflowStep::where('titre', "Reouverture Facture")->first();
        $action = WorkflowAction::createNew("Numéro facture", "Numéro facture")
            ->setActionType($string_type, true)
            ->setRequired(true,"Prière de renseigner le numéro de facture", true)
        ;
        $workflow_step->addValidationAction($action, true);
        $workflow_step->addRejectionAction($motif_rejet_action, true);

        // Encaissement Facture
        $workflow_step = WorkflowStep::where('titre', "Encaissement Facture")->first();
        $action = WorkflowAction::createNew("Montant encaissé", "Montant encaissé")
            ->setActionType($string_type, true)
            ->setRequired(true,"Prière de renseigner le Montant", true)
        ;
        $workflow_step->addValidationAction($action, true);
        $workflow_step->addRejectionAction($motif_rejet_action, true);


        // 6 - date_traitement_dfr
        $workflow_step = WorkflowStep::where('titre', "Traitement DFR")->first();
        $action = WorkflowAction::createNew("Date Traitement (DFR)", "Date Traitement (DFR)")
            ->setActionType($date_type, true)
            ->setRequired(false,null, true)
        ;
        $workflow_step->addValidationAction($action, true);
        $workflow_step->addRejectionAction($motif_rejet_action, true);

        // 7 - date_traitement_dfr
        $action = WorkflowAction::createNew("Commentaire (DFR)", "Commentaire (DFR)")
            ->setActionType($string_type, true)
            ->setRequired(false,null, true)
        ;
        $workflow_step->addValidationAction($action, true);
    }
}
