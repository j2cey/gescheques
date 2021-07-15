<?php

namespace Database\Seeders;

use App\Models\WorkflowStep;
use Illuminate\Database\Seeder;

class WorkflowStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        $step_end = $this->createNew("Traitement Terminé", "step_end", "Etape marquant la fin de tout Workflow", 0, null, null,null,null);

        // 2
        $step = $this->createNew("Traitement Finances", "step_0", "Traitements niveau Finances", 0, 1, 4,null,$step_end->id);
        // 3
        $prevstep = $step;
        $step = $this->createNew("Traitement Agence", "step_1", "Traitements niveau Agence", 1, 1, null,$step_end->id,null,false,true, "Agence");
        $prevstep->update(['validated_nextstep_id' => $step->id]);
        // 4
        $prevstep = $step;
        $step = $this->createNew("Traitement DFR", "step_2", "Traitements niveau DFR", 2, 1, 5,$prevstep->id,$step_end->id);
        $prevstep->update(['rejected_nextstep_id' => $step->id]);
    }

    private function createNew($titre, $code, $description, $posi, $workflow_id, $role_id, $validated_nextstep_id, $rejected_nextstep_id, $role_static = true, $role_dynamic = false, $role_dynamic_label = null)
    {
        $data = [
            'titre' => $titre, 'code' => $code, 'description' => $description, 'posi' => $posi,
            'role_static' => $role_static, 'role_dynamic' => $role_dynamic,
        ];

        if (! is_null($role_dynamic_label)) $data['role_dynamic_label'] = $role_dynamic_label;

        if (! is_null($workflow_id)) $data['workflow_id'] = $workflow_id;
        if (! is_null($workflow_id)) $data['role_id'] = $role_id;
        if (! is_null($workflow_id)) $data['validated_nextstep_id'] = $validated_nextstep_id;
        if (! is_null($workflow_id)) $data['rejected_nextstep_id'] = $rejected_nextstep_id;

        return WorkflowStep::create($data);
    }
}
