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
                'model_type' => "App\Models\Bordereau", 'model_title' => "Bordereau"
            ],
            [
                'model_type' => "App\Models\Cheque", 'model_title' => "Cheque", 'ref_field' => "bordereau_id"
            ],
        ];
        foreach ($workflowobjects as $workflowobject) {
            WorkflowObject::create($workflowobject);
        }
    }
}
