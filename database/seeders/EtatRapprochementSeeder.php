<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EtatRapprochement;

class EtatRapprochementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1 - encaissement non effectif
        $this->createNew("Encaissement non effectif", "encaissement_non_effectif", "encaissement ARIS non rapproché");
        $this->createNew("Encaissement effectif", "encaissement_effectif", "encaissement ARIS rapproché");
    }

    private function createNew($name, $code, $description)
    {
        $data = ['name' => $name, 'code' => $code, 'description' => $description];
        return EtatRapprochement::create($data);
    }
}
