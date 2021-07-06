<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BordereauremiseEtat;

class BordereauremiseEtatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $etats = [
            [
                'titre' => "Attente Traitement", 'code' => "state_1", 'description' => "Bordereau ou Ligne en attenteb de traitement"
            ],
            [
                'titre' => "Traitement En Cours", 'code' => "state_2", 'description' => "Bordereau ou Ligne en cours de traitement"
            ],
            [
                'titre' => "Validé Sans Ecart", 'code' => "state_3", 'description' => "Bordereau ou Ligne validé(e) sans écart"
            ],
            [
                'titre' => "Validé Avec Ecart Positif", 'code' => "state_4", 'description' => "Bordereau ou Ligne validé(e) avec un écart positif"
            ],
            [
                'titre' => "Validé Avec Ecart Négatif", 'code' => "state_5", 'description' => "Bordereau ou Ligne validé(e) mais avec un écart négatif"
            ],
            [
                'titre' => "Rejété", 'code' => "state_6", 'description' => "Bordereau ou Ligne rejété(e)"
            ]
        ];
        foreach ($etats as $etat) {
            BordereauremiseEtat::create($etat);
        }
    }
}
