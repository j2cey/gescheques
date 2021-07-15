<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AgenceResource
 * @package App\Http\Resources
 *
 * @property string $uuid
 * @property bool $is_default
 *
 * @property string|null $Location
 * @property string $LocationName
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class AgenceResource extends JsonResource
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
            'Location' => $this->Location,
            'LocationName' => $this->LocationName,
        ];
    }
}
