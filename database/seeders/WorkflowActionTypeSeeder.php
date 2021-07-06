<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkflowActionType;

class WorkflowActionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actiontypes = [
            [
                'titre' => "Sur Workflow", 'code' => "1", 'is_default' => 1
            ],
            [
                'titre' => "Sur Objet", 'code' => "2", 'is_default' => 0
            ]
        ];
        foreach ($actiontypes as $actiontype) {
            WorkflowActionType::create($actiontype);
        }
    }
}
