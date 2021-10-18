<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['role-list', 2],
            ['role-create', 1],
            ['role-edit', 1],
            ['role-delete', 1],

            ['workflow-list', 4],
            ['workflow-create', 3],
            ['workflow-edit', 2],
            ['workflow-delete', 1],

            ['flowchart-list', 4],
            ['flowchart-create', 3],
            ['flowchart-edit', 2],
            ['flowchart-delete', 1],
            ['flowchart-save', 1],

            ['enumtype-list', 4],
            ['enumtype-create', 3],
            ['enumtype-edit', 2],
            ['enumtype-delete', 1],
            ['enumtype-save', 1],
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission[0], 'level' => $permission[1]]);
        }
    }
}
