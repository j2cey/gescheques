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
                'titre' => "Traitement Chèque impayés",
                'description' => "Processus de Traitement des Chèques impayés",
                'user_id' => 1,
                'workflow_object_id' => 2,
                'model_type' => "App\Models\Cheque",
            ],
        ];
        foreach ($workflows as $workflow) {
            Workflow::create($workflow);
        }
    }
}
