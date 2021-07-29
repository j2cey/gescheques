<?php

namespace App\Http\Resources;

use App\Models\Status;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Cheque
 * @package App\Http\Resources
 *
 * @property integer $id
 * @property string $uuid
 *
 * @property string $NREC_BANK_MVT_ID
 * @property string $ACC_CODE
 * @property string $TRN_AMOUNT
 * @property string $CHEQUE_NB
 * @property string $DESCRIPTION
 * @property string $COMPLEMENTS1
 *
 * @property string $workflow_currentstep_code
 * @property string $workflow_currentstep_titre
 */
class Cheque extends JsonResource
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

            'NREC_BANK_MVT_ID' => $this->NREC_BANK_MVT_ID,
            'ACC_CODE' => $this->ACC_CODE,
            'TRN_AMOUNT' => $this->TRN_AMOUNT,
            'CHEQUE_NB' => $this->CHEQUE_NB,
            'DESCRIPTION' => $this->DESCRIPTION,
            'COMPLEMENTS1' => $this->COMPLEMENTS1,

            'workflow_currentstep_titre' => $this->workflow_currentstep_titre,
            'workflow_currentstep_code' => $this->workflow_currentstep_code,

            'status' => StatusResource::make($this->status),
            'encaissement' => EncaissementResource::make($this->encaissement),
            'workflowexec' => WorkflowExecResource::make($this->workflowexec),

            'edit_url' => route('cheques.show', $this->uuid),
            'destroy_url' => route('cheques.destroy', $this->uuid),
        ];
    }
}
