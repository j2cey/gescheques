<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class BordereauremiseLoc
 * @package App\Http\Resources
 *
 * @property integer $id
 * @property string $uuid
 * @property string $titre
 * @property string $code
 * @property string $description
 */
class BordereauremiseLoc extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'titre' => $this->titre,
            'code' => $this->code,
            'description' => $this->description,
        ];
    }
}
