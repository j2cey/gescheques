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
        $adminrole = Role::create(['name' => 'Admin', 'description' => "Administrateur du Système"]);
        $defaultrole = Role::create(['name' => 'Simple User', 'description' => "Utilisateur invité"]);
        $agences = Role::create(['name' => 'Agences', 'description' => "Employé Agences"]);
        $finances = Role::create(['name' => 'Division Finances', 'description' => "Employé Division Finances"]);
        $dfr = Role::create(['name' => 'DFR', 'description' => "Employé DFR"]);
    }
}
