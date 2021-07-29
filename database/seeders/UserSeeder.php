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
        $user = User::create(['name' => "admin",'username' => "admin",'email' => "admin@gabontelecom.ga",'password' => bcrypt('MyAdmin@123'), 'is_local' => 1, 'status_id' => Status::active()->first()->id]);
        $user2 = User::create(['name' => "Agences Default User",'username' => "Agences Default User",'email' => "agences@gabontelecom.ga",'password' => bcrypt('agences123'), 'is_local' => 1, 'status_id' => Status::active()->first()->id]);
        $user3 = User::create(['name' => "Finances Default User",'username' => "Finances Default User",'email' => "finances@gabontelecom.ga",'password' => bcrypt('finances123'), 'is_local' => 1, 'status_id' => Status::active()->first()->id]);
        $user4 = User::create(['name' => "DFR Default User",'username' => "DFR Default User",'email' => "dfr@gabontelecom.ga",'password' => bcrypt('dfr123'), 'is_local' => 1, 'status_id' => Status::active()->first()->id]);

        $adminrole = Role::where('name', 'Admin')->first();
        $agencerole = Role::where('name', 'Agences')->first();
        $financerole = Role::where('name', 'Division Finances')->first();
        $dfrrole = Role::where('name', 'DFR')->first();

        $permissions = Permission::pluck('id','id')->all();

        $adminrole->syncPermissions($permissions);
        //$agencerole->syncPermissions($permissions);
        //$financerole->syncPermissions($permissions);
        //$dfrrole->syncPermissions($permissions);

        $user->assignRole([$adminrole->id]);
        $user2->assignRole([$agencerole->id]);
        $user3->assignRole([$financerole->id]);
        $user4->assignRole([$dfrrole->id]);
    }
}
