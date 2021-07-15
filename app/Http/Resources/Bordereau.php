<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Bordereau
 * @package App\Http\Resources
 *
 * @property integer $id
 * @property string $uuid
 * @property string $numero_transaction
 * @property string $montant_total
 * @property string $localisation
 * @property string $titre
 * @property string $localisation_titre
 * @property string $modepaiement_titre
 * @property string $classe_paiement
 * @property string $workflow_currentstep_code
 * @property string $workflow_currentstep_titre
 */
class Bordereau extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'date_validation_finance' => $this->date_validation_finance,

            'edit_url' => route('bordereaus.edit', $this->uuid),
            'destroy_url' => route('bordereaus.destroy', $this->uuid),
        ];
    }
}
