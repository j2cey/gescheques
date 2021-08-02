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
        WorkflowTreatmentType::createNew("validation", "validation_treatment", "Traitement de validation");
        WorkflowTreatmentType::createNew("rejet", "rejection_treatment", "Traitement de rejet");
        WorkflowTreatmentType::createNew("expiration", "expiration_treatment", "Traitement d expiration");
    }
}
