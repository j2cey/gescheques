<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkflowObjectFieldType;

class WorkflowObjectFieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        $this->createNew("string", "valuetype_string");
        // 2
        $this->createNew("integer", "valuetype_integer");
        // 3
        $this->createNew("boolean", "valuetype_boolean");
        // 4
        $this->createNew("datetime", "valuetype_datetime");
        // 5
        $this->createNew("image", "valuetype_image");
    }

    private function createNew($name, $code)
    {
        $data = ['name' => $name, 'code' => $code];

        return WorkflowObjectFieldType::create($data);
    }
}
