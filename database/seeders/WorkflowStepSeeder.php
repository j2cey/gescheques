<?php

namespace Database\Seeders;

use App\Models\Workflow;
use App\Models\WorkflowStep;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class WorkflowStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agencerole = Role::where('name', 'Agences')->first();
        $financerole = Role::where('name', 'Division Finances')->first();
        $dfrrole = Role::where('name', 'DFR')->first();

        // Traitement Terminé
        $step_end = WorkflowStep::createNew("Traitement Terminé", "Etape marquant la fin de tout Workflow", null,"step_end");
        // Traitement Rejeté
        $step_rejected = WorkflowStep::createNew("Traitement Rejeté", "Etape marquant le rejet de tout Workflow", null,"step_rejected");
        // Traitement Expiré
        $step_expired = WorkflowStep::createNew("Traitement Expiré", "Etape marquant l expiration de tout Workflow", null,"step_expired");

        // Workflow
        $workflow = Workflow::where('id',1)->first();
        // Traitement Finances
        $step_finances = WorkflowStep::createNew("Traitement Finances", "Traitements niveau Finances", $workflow)
            ->setProfileStatic(true, $financerole,true)
            ->setNextStepAfterRejected($step_end, true);
        // Traitement Agences
        $step_agences = WorkflowStep::createNew("Traitement Agences", "Traitements niveau Agence", $workflow)
            ->setProfileDynamic(true,"Agence", "Agence Précédente", true)
            ->setNextStepAfterValidated($step_end, true)
        ;
        // Traitement Finances - validated_nextstep: Traitement Agences
        $step_finances->setNextStepAfterValidated($step_agences, true);

        // Traitement DFR
        $step_dfr = WorkflowStep::createNew("Traitement DFR", "Traitements niveau DFR", $workflow)
            ->setProfileStatic(true, $dfrrole,true)
            ->setNextStepAfterValidated($step_agences, true)
            ->setNextStepAfterRejected($step_end, true)
        ;
        // Traitement Agences - rejected_nextstep: Traitement DFR
        $step_agences->setNextStepAfterRejected($step_dfr, true);
    }
}
