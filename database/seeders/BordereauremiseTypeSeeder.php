<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BordereauremiseType;

class BordereauremiseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bordereauremisetypes = [
            [
                'code' => "BT_0", 'titre' => "Espèce"
            ],
            [
                'code' => "BT_1", 'titre' => "Chèque"
            ],
        ];
        foreach ($bordereauremisetypes as $bordereauremisetype) {
            BordereauremiseType::create($bordereauremisetype);
        }
    }
}
