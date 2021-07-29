<?php

namespace Database\Seeders;

use App\Models\MimeType;
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
        $mime_types_ids = MimeType::whereIn('extension', ['png','jpg','bmp','pdf'])->get()->pluck('id');

        // 0 - motif rejet
        $workflow_step = WorkflowStep::where('code', "step_rejected")->first();
        WorkflowAction::createNew("Motif Rejet", "Motif Rejet", null, null, "motif_rejet_action")
            ->setStep($workflow_step, true)
            ->setActionType($string_type, true)
            ->setRequired(false,null, true)
        ;

        // 1 - date_traitement_finance
        $workflow_step = WorkflowStep::where('titre', "Traitement Finances")->first();
        WorkflowAction::createNew("Date Traitement (Finances)", "Date Traitement (Finances)")
            ->setStep($workflow_step, true)
            ->setActionType($date_type, true)
            ->setRequired(false,null, true)
        ;

        // 2 - commentaire_finance
        WorkflowAction::createNew("Commentaire (Finances)", "Commentaire (Finances)")
            ->setStep($workflow_step, true)
            ->setActionType($string_type, true)
            ->setRequired(false,null, true)
        ;

        // 3 - scan_cheque
        WorkflowAction::createNew("Scan Cheque", "Scan Cheque")
            ->setStep($workflow_step, true)
            ->setActionType($file_type, true)
            ->setRequired(false,null, true)
            ->setMimeTypes($mime_types_ids, true)
        ;

        // 4 - commentaire_finance
        $workflow_step = WorkflowStep::where('titre', "Traitement Agences")->first();
        WorkflowAction::createNew("Date Traitement (Agences)", "Date Traitement (Agences)")
            ->setStep($workflow_step, true)
            ->setActionType($date_type, true)
            ->setRequired(false,null, true)
        ;

        // 5 - commentaire_finance
        WorkflowAction::createNew("Commentaire (Agences)", "Commentaire (Agences)")
            ->setStep($workflow_step, true)
            ->setActionType($string_type, true)
            ->setRequired(false,null, true)
        ;

        // 6 - date_traitement_dfr
        $workflow_step = WorkflowStep::where('titre', "Traitement DFR")->first();
        WorkflowAction::createNew("Date Traitement (DFR)", "Date Traitement (DFR)")
            ->setStep($workflow_step, true)
            ->setActionType($date_type, true)
            ->setRequired(false,null, true)
        ;

        // 7 - date_traitement_dfr
        WorkflowAction::createNew("Commentaire (DFR)", "Commentaire (DFR)")
            ->setStep($workflow_step, true)
            ->setActionType($string_type, true)
            ->setRequired(false,null, true)
        ;
    }
}
