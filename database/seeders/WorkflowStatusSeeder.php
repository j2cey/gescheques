<?php

namespace Database\Seeders;

use App\Models\WorkflowStatus;
use Illuminate\Database\Seeder;

class WorkflowStatusSeeder extends Seeder
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
                'name' => "Nouveau", 'code' => "new", 'is_default' => 1
            ],
            [
                'name' => "Attente Traitement", 'code' => "pending", 'is_default' => 0
            ],
            [
                'name' => "En Cours de Traitement", 'code' => "processing", 'is_default' => 0
            ],
            [
                'name' => "Traitement Validé", 'code' => "validated", 'is_default' => 0
            ],
            [
                'name' => "Traitement Rejété", 'code' => "rejected", 'is_default' => 0
            ],
            [
                'name' => "Traitement Rejété", 'code' => "expired", 'is_default' => 0
            ]
        ];
        foreach ($statuses as $status) {
            WorkflowStatus::create($status);
        }
    }
}
