<?php

namespace Database\Seeders;

use App\Models\Workflow;
use Illuminate\Database\Seeder;

class WorkflowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workflows = [
            [
                'titre' => "Traitement Bordereaux Remise",
                'description' => "Processus de Traitement des Bordereaux de Remise",
                'user_id' => 1,
                'workflow_object_id' => 1,
                'model_type' => "App\Models\Bordereauremise",
            ],
        ];
        foreach ($workflows as $workflow) {
            Workflow::create($workflow);
        }
    }
}
