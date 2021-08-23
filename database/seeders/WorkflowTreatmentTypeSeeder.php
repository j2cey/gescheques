<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkflowTreatmentType;

class WorkflowTreatmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkflowTreatmentType::createNew("validation", "pass", "Traitement de validation", "approve");
        WorkflowTreatmentType::createNew("rejet", "reject", "Traitement de rejet", "delete");
        WorkflowTreatmentType::createNew("expiration", "expire", "Traitement d expiration", "delete");
        WorkflowTreatmentType::createNew("toujours", "allways", "Tout Traitement", "delete");
    }
}
