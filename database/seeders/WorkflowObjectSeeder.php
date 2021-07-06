<?php

namespace Database\Seeders;

use App\Models\WorkflowObject;
use Illuminate\Database\Seeder;

class WorkflowObjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workflowobjects = [
            [
                'model_type' => "App\Models\Bordereauremise", 'model_title' => "Bordereau Remise"
            ],
            [
                'model_type' => "App\Models\BordereauremiseLigne", 'model_title' => "Ligne Bordereau Remise", 'workflow_object_parent_id' => 1, 'ref_field' => "bordereauremise_id"
            ],
        ];
        foreach ($workflowobjects as $workflowobject) {
            WorkflowObject::create($workflowobject);
        }
    }
}
