<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkflowObjectField;

class WorkflowObjectFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objectfields = [
            [
                'db_field_name' => "date_depot_agence", 'field_label' => "Date Dépôt Agence", 'valuetype_datetime' => true,
                'workflow_object_id' => 1
            ],
            [
                'db_field_name' => "montant_depose_agence", 'field_label' => "Montant Déposé (Agence)", 'valuetype_integer' => true,
                'workflow_object_id' => 1
            ],
            [
                'db_field_name' => "scan_bordereau", 'field_label' => "Scan Bordereau", 'valuetype_image' => true,
                'workflow_object_id' => 1
            ],
            [
                'db_field_name' => "commentaire_agence", 'field_label' => "Commentaire Agence", 'valuetype_string' => true,
                'workflow_object_id' => 1
            ],
            [
                'db_field_name' => "date_valeur_finance", 'field_label' => "Date Valeur", 'valuetype_datetime' => true,
                'workflow_object_id' => 2
            ],
            [
                'db_field_name' => "montant_depose_finance", 'field_label' => "Montant Validé (Finances)", 'valuetype_integer' => true,
                'workflow_object_id' => 2
            ],
            [
                'db_field_name' => "commentaire_finance", 'field_label' => "Commentaire Finance", 'valuetype_string' => true,
                'workflow_object_id' => 2
            ],
            [
                'db_field_name' => "rejet_finances", 'field_label' => "Rejet Finances", 'valuetype_boolean' => true,
                'workflow_object_id' => 2
            ],
            [
                'db_field_name' => "motif_rejet_finances", 'field_label' => "Motif Rejet Finances", 'valuetype_string' => true,
                'workflow_object_id' => 2
            ],
        ];
        foreach ($objectfields as $objectfield) {
            WorkflowObjectField::create($objectfield);
        }
    }
}
