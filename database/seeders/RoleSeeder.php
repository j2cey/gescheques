<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $simplerole = Role::create(['name' => 'Simple', 'description' => "System Guess Role"]);
        $adminrole = Role::create(['name' => 'Admin', 'description' => "Administrateur du Système"]);
        $agences = Role::create(['name' => 'Agences', 'description' => "Employé Agences"]);
        $finances = Role::create(['name' => 'Division Finances', 'description' => "Employé Division Finances"]);
        $dfr = Role::create(['name' => 'DFR', 'description' => "Employé DFR"]);
    }
}
