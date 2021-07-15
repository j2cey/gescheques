<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkflowObjectField;
use App\Models\WorkflowObjectFieldType;

class WorkflowObjectFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $valuetype_datetime = WorkflowObjectFieldType::where('code', "valuetype_datetime")->first();
        $valuetype_string = WorkflowObjectFieldType::where('code', "valuetype_string")->first();
        $valuetype_image = WorkflowObjectFieldType::where('code', "valuetype_image")->first();
        // 10 - date_traitement_finance
        $this->createNew("date_traitement_finance", "Date Traitement Finance", 2, $valuetype_datetime);
        // 11 - commentaire_finance
        $this->createNew("commentaire_finance", "Commentaire Finances", 2, $valuetype_string);
        // 12 - scan_cheque
        $this->createNew("scan_cheque", "Scan Cheque", 2, $valuetype_image);
        // 13 - date_traitement_agence
        $this->createNew("date_traitement_agence", "Date Traitement Agence", 2, $valuetype_datetime);
        // 14 - commentaire_agence
        $this->createNew("commentaire_agence", "Commentaire Agence", 2, $valuetype_string);

        // 15 - date_traitement_dfr
        $this->createNew("date_traitement_dfr", "Date Traitement DFR", 2, $valuetype_datetime);
        // 16 - commentaire_dfr
        $this->createNew("commentaire_dfr", "Commentaire DFR", 2, $valuetype_string);
    }

    private function createNew($db_field_name, $field_label, $workflow_object_id, $workflow_object_field_type)
    {
        $data = ['db_field_name' => $db_field_name, 'field_label' => $field_label, 'workflow_object_id' => $workflow_object_id, 'workflow_object_field_type_id' => $workflow_object_field_type->id];

        return WorkflowObjectField::create($data);
    }
}
