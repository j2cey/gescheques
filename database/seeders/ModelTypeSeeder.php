<?php

namespace Database\Seeders;

use App\Models\ModelType;
use Illuminate\Database\Seeder;

class ModelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelType::updateList();
    }
}
