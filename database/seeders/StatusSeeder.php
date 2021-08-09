<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $active_status = $this->createNew("active", "active", "active object");
        $inactive_status = $this->createNew("inactive", "inactive", "inactive object");

        $active_status->setDefault();
    }

    private function createNew($name, $code, $description) : Status {
        return Status::create([
            'name' => $name, 'code' => $code, 'description' => $description,
            ]);
    }
}
