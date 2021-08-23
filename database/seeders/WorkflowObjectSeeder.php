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
                'model_type' => "App\Models\Bordereau", 'model_title' => "Bordereau",
                'route_raw' => "borderaus", 'route_show' => "borderaus.show"
            ],
            [
                'model_type' => "App\Models\Cheque", 'model_title' => "Cheque", 'ref_field' => "bordereau_id",
                'route_raw' => "cheques", 'route_show' => "cheques.show",
            ],
        ];
        foreach ($workflowobjects as $workflowobject) {
            WorkflowObject::create($workflowobject);
        }
    }
}
