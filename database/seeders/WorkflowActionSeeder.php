<?php

namespace Database\Seeders;

use App\Models\WorkflowStep;
use App\Models\WorkflowAction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\WorkflowObjectField;

class WorkflowActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1 - date_traitement_finance
        $workflow_step = WorkflowStep::where('id', 2)->first();
        $workflow_object_field = WorkflowObjectField::where('db_field_name', "date_traitement_finance")->first();
        $this->createNew("Date Traitement (Finances)", "Date Traitement (Finances)", $workflow_step, $workflow_object_field, 0);

        // 2 - commentaire_finance
        $workflow_object_field = WorkflowObjectField::where('db_field_name', "commentaire_finance")->first();
        $this->createNew("Commentaire (Finances)", "Commentaire (Finances)", $workflow_step, $workflow_object_field, 0);

        // 3 - scan_cheque
        $workflow_object_field = WorkflowObjectField::where('db_field_name', "scan_cheque")->first();
        $this->createNew("Scan Cheque", "Scan Cheque", $workflow_step, $workflow_object_field, 0);

        // 4 - commentaire_finance
        $workflow_step = WorkflowStep::where('id', 3)->first();
        $workflow_object_field = WorkflowObjectField::where('db_field_name', "date_traitement_agence")->first();
        $this->createNew("Date Traitement (Agences)", "Date Traitement (Agences)", $workflow_step, $workflow_object_field, 0);

        // 5 - commentaire_finance
        $workflow_step = WorkflowStep::where('id', 3)->first();
        $workflow_object_field = WorkflowObjectField::where('db_field_name', "commentaire_agence")->first();
        $this->createNew("Commentaire (Agences)", "Commentaire (Agences)", $workflow_step, $workflow_object_field, 0);

        // 6 - date_traitement_dfr
        $workflow_step = WorkflowStep::where('id', 4)->first();
        $workflow_object_field = WorkflowObjectField::where('db_field_name', "date_traitement_dfr")->first();
        $this->createNew("Date Traitement (DFR)", "Date Traitement (DFR)", $workflow_step, $workflow_object_field, 0);

        // 7 - date_traitement_dfr
        $workflow_step = WorkflowStep::where('id', 4)->first();
        $workflow_object_field = WorkflowObjectField::where('db_field_name', "commentaire_dfr")->first();
        $this->createNew("Commentaire (DFR)", "Commentaire (DFR)", $workflow_step, $workflow_object_field, 0);

        // create fields required without list
        /*DB::table('fields_required_without')->insert([
            [ 'workflow_action_id' => 5, 'workflow_object_field_id' => 8,],
            [ 'workflow_action_id' => 6, 'workflow_object_field_id' => 8,],
        ]);*/
        // create fields required with list
        /*DB::table('fields_required_with')->insert([
                'workflow_action_id' => 8,'workflow_object_field_id' => 8,
            ]
        );*/
    }

    private function createNew($titre, $description, $workflow_step, $workflow_object_field, $field_required)
    {
        $data = ['titre' => $titre, 'description' => $description, 'workflow_step_id' => $workflow_step->id,
            'workflow_object_field_id' => $workflow_object_field->id, 'field_required' => $field_required
        ];

        return WorkflowAction::create($data);
    }
}
