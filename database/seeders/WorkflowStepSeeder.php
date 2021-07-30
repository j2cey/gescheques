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
        $step_finances = WorkflowStep::createNew("Réception Finances", "Réception & Enregistrement niveau Finances", $workflow)
            ->setProfileStatic(true, $financerole,true)
            ->setNextStepAfterRejected($step_end, true);

        // Traitement Agences
        $step_agences = WorkflowStep::createNew("Réception Agences", "Traitements niveau Agence", $workflow)
            ->setProfileDynamic(true,"Agence", "Agence Précédente", true)
        ;

        // Traitement Agences > Relance Client
        $step_relance_clt = WorkflowStep::createNew("Relance Client", "Traitements Relance Client (Agences)", $workflow)
            ->setProfilePrevious(true, true)
            ->setSetpParent($step_agences, true)
        ;
        $step_agences->setNextStepAfterValidated($step_relance_clt, true);

        // Traitement Agences > Reouverture Facture
        $step_reouverture_facture = WorkflowStep::createNew("Reouverture Facture", "Traitements Reouverture Facture (Agences)", $workflow)
            ->setProfilePrevious(true, true)
            ->setSetpParent($step_agences, true)
        ;
        $step_relance_clt->setNextStepAfterValidated($step_reouverture_facture, true);

        // Traitement Agences > Encaissement Facture
        $step_encaissement_facture = WorkflowStep::createNew("Encaissement Facture", "Encaissement Reouverture Facture (Agences)", $workflow)
            ->setProfilePrevious(true, true)
            ->setSetpParent($step_agences, true)
        ;
        $step_reouverture_facture->setNextStepAfterValidated($step_encaissement_facture, true);

        // Traitement Compta
        $step_finances_compta = WorkflowStep::createNew("Comptabilisation", "Comptabilisation après retraitement", $workflow)
            ->setProfileStatic(true, $financerole,true)
            ->setNextStepAfterRejected($step_end, true)
            ->setNextStepAfterValidated($step_end, true)
        ;
        $step_encaissement_facture->setNextStepAfterValidated($step_finances_compta, true);

        // Traitement DFR
        $step_dfr = WorkflowStep::createNew("Traitement DFR", "Traitements niveau DFR", $workflow)
            ->setProfileStatic(true, $dfrrole,true)
            ->setNextStepAfterRejected($step_end, true)
        ;

        $step_agences->setNextStepAfterRejected($step_dfr, true);
        $step_relance_clt->setNextStepAfterRejected($step_dfr, true);
        $step_reouverture_facture->setNextStepAfterRejected($step_dfr, true);
        $step_encaissement_facture->setNextStepAfterRejected($step_dfr, true);

        // Traitement Finances - validated_nextstep: Traitement Agences
        $step_finances->setNextStepAfterValidated($step_agences, true);

        $step_dfr->setNextStepAfterValidated($step_agences, true);
    }
}
