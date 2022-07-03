<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SettingSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ModelTypeSeeder::class);

        $this->call(MimeTypeSeeder::class);
        $this->call(ReminderCriterionTypeSeeder::class);

        $this->call(WorkflowStatusSeeder::class);
        $this->call(WorkflowProcessStatusSeeder::class);
        $this->call(WorkflowTreatmentTypeSeeder::class);
        $this->call(WorkflowStepTypeSeeder::class);
        $this->call(WorkflowObjectSeeder::class);
        $this->call(WorkflowObjectFieldTypeSeeder::class);
        $this->call(WorkflowObjectFieldSeeder::class);

        //$this->call(WorkflowSeeder::class);
        //$this->call(WorkflowStepSeeder::class);
        $this->call(WorkflowActionTypeSeeder::class);
        //$this->call(WorkflowActionSeeder::class);
        $this->call(InitWorkflowSeeder::class);

        $this->call(TypeDepartementSeeder::class);
        $this->call(EtatRapprochementSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
