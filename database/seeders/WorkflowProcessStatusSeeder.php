<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkflowProcessStatus;

class WorkflowProcessStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'name' => "Attente Traitement", 'code' => "pending", 'is_default' => 0
            ],
            [
                'name' => "En Cours de Traitement", 'code' => "processing", 'is_default' => 0
            ],
            [
                'name' => "Traitement Effectif", 'code' => "processed", 'is_default' => 0
            ],
            [
                'name' => "Echèc Traitement", 'code' => "failed", 'is_default' => 0
            ]
        ];
        foreach ($statuses as $status) {
            WorkflowProcessStatus::create($status);
        }
    }
}
