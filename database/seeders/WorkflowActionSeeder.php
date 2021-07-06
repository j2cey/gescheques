<?php

namespace Database\Seeders;

use App\Models\WorkflowAction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkflowActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workflowactions = [
            [ // 1
                'titre' => "Date Dépôt",
                'description' => "Date Dépôt Agence",
                'workflow_action_type_id' => 2,
                'workflow_step_id' => 2,
                'workflow_object_field_id' => 1, // Date Dépôt Agence
                'field_required' => 1,
                'field_required_msg' => "Prière de renseigner la Date Dépôt",
            ],
            [ // 2
                'titre' => "Montant Déposé",
                'description' => "Montant Déposé (Agence)",
                'workflow_action_type_id' => 2,
                'workflow_step_id' => 2,
                'workflow_object_field_id' => 2, // Montant Déposé (Agence)
                'field_required' => 1,
                'field_required_msg' => "Prière de renseigner le Montant Déposé",
            ],
            [ // 3
                'titre' => "Scan Bordereau",
                'description' => "Scan Bordereau (Agence)",
                'workflow_action_type_id' => 2,
                'workflow_step_id' => 2,
                'workflow_object_field_id' => 3, // Scan Bordereau
                'field_required' => 1,
                'field_required_msg' => "Prière de joindre le Scan du Bordereau",
            ],
            [ // 4
                'titre' => "Commentaire",
                'description' => "Commentaire (Agence)",
                'workflow_action_type_id' => 2,
                'workflow_step_id' => 2,
                'workflow_object_field_id' => 4, // Commentaire Agence
                'field_required' => 0,
            ],
            [ // 5
                'titre' => "Date Valeur",
                'description' => "Date Valeur (Finances)",
                'workflow_action_type_id' => 2,
                'workflow_step_id' => 3,
                'workflow_object_field_id' => 5, // Date Valeur
                'field_required_without' => 1, // Requis (sans) quand le rejet n'est pas activé
                'field_required_without_msg' => "Prière de renseigner la Date Valeur",
            ],
            [ // 6
                'titre' => "Montant Validé",
                'description' => "Montant Validé (Finances)",
                'workflow_action_type_id' => 2,
                'workflow_step_id' => 3,
                'workflow_object_field_id' => 6, // Montant Validé (Finances)
                'field_required_without' => 1, // Requis (sans) quand le rejet n'est pas activé
                'field_required_without_msg' => "Prière de renseigner le Montant Validé",
            ],
            [ // 7
                'titre' => "Rejeter",
                'description' => "Rejet (Finances)",
                'workflow_action_type_id' => 2,
                'workflow_step_id' => 3,
                'workflow_object_field_id' => 8, // Rejet (Finances)
                'field_required' => 0,
            ],
            [ // 8
                'titre' => "Motif Rejet",
                'description' => "Motif Rejet (Finances)",
                'workflow_action_type_id' => 2,
                'workflow_step_id' => 3,
                'workflow_object_field_id' => 9, // Motif Rejet (Finances)
                'field_required_with' => 1, // Requis (avec) quand le rejet est activé
                'field_required_with_msg' => "Le Motif est nécéssaire pour valider le Réjet",
            ],
            [ // 9
                'titre' => "Commentaire",
                'description' => "Commentaire (Finances)",
                'workflow_action_type_id' => 2,
                'workflow_step_id' => 3,
                'workflow_object_field_id' => 7, // Commentaire (Finances)
                'field_required' => 0,
            ],
        ];
        foreach ($workflowactions as $workflowaction) {
            WorkflowAction::create($workflowaction);
        }
        // create fields required without list
        DB::table('fields_required_without')->insert([
            [ 'workflow_action_id' => 5, 'workflow_object_field_id' => 8,],
            [ 'workflow_action_id' => 6, 'workflow_object_field_id' => 8,],
        ]);
        // create fields required with list
        DB::table('fields_required_with')->insert([
                'workflow_action_id' => 8,'workflow_object_field_id' => 8,
            ]
        );
    }
}
