<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class EncaissementResource
 * @package App\Http\Resources
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $Reference
 *
 * @property string $Initial_TotalAmountPaid
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class EncaissementResource extends JsonResource
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
            'uuid' => $this->uuid,
            'Reference' => $this->Reference,
            'Initial_TotalAmountPaid' => $this->Initial_TotalAmountPaid,
            'agence' => AgenceResource::make($this->agence),
        ];
    }
}
