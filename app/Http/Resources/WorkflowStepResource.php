<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class WorkflowStepResource
 * @package App\Http\Resources
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $code
 * @property string $titre
 * @property integer $posi
 * @property string|null $description
 */
class WorkflowStepResource extends JsonResource
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
            'is_default' => $this->is_default,
            'tags' => $this->tags,

            'code' => $this->code,
            'titre' => $this->titre,
            'posi' => $this->posi,
            'description' => $this->description,
        ];
    }
}
