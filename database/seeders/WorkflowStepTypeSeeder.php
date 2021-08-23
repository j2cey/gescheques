<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkflowStepType;

class WorkflowStepTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkflowStepType::createNew("Début", "start", "Etape de départ");
        WorkflowStepType::createNew("Fin", "end", "Etape de fin");
        WorkflowStepType::createNew("Opération", "operation", "Etape d opération (traitement)");
    }
}
