<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Status;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(['name' => "admin",'username' => "admin",'email' => "admin@gabontelecom.ga",'password' => bcrypt('admin123'), 'is_local' => 1, 'status_id' => Status::active()->first()->id]);
        $user2 = User::create(['name' => "chef agence",'username' => "chef agence",'email' => "agence@gabontelecom.ga",'password' => bcrypt('admin123'), 'is_local' => 1, 'status_id' => Status::active()->first()->id]);
        $user3 = User::create(['name' => "finance",'username' => "finance",'email' => "finance@gabontelecom.ga",'password' => bcrypt('admin123'), 'is_local' => 1, 'status_id' => Status::active()->first()->id]);
        $user4 = User::create(['name' => "dfr",'username' => "dfr",'email' => "dfr@gabontelecom.ga",'password' => bcrypt('admin123'), 'is_local' => 1, 'status_id' => Status::active()->first()->id]);

        $adminrole = Role::create(['name' => 'Admin']);
        $agencerole = Role::create(['name' => 'Chef Agence']);
        $financerole = Role::create(['name' => 'Financier']);
        $dfrrole = Role::create(['name' => 'DFR']);

        $permissions = Permission::pluck('id','id')->all();

        $adminrole->syncPermissions($permissions);
        $agencerole->syncPermissions($permissions);
        $financerole->syncPermissions($permissions);
        $dfrrole->syncPermissions($permissions);

        $user->assignRole([$adminrole->id]);
        $user2->assignRole([$agencerole->id]);
        $user3->assignRole([$financerole->id]);
        $user4->assignRole([$dfrrole->id]);
    }
}
