<?php

namespace App\Http\Resources;

use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class EncaissementResource
 * @package App\Http\Resources
 *
 * @property string $id
 * @property string $uuid
 * @property bool $is_default
 *
 * @property string|null $PaymentKey
 * @property string|null $ReceiptNum
 * @property string|null $Reference
 * @property string|null $PaymentID
 * @property Carbon|null $DatePaid
 * @property string|null $EmployeeCode
 * @property string|null $CustomerNo
 * @property string|null $PaymentClass
 * @property string|null $OSS360_PaymentClass
 * @property string|null $OSS360_PaymentType
 * @property Carbon|null $HistoryDateTime
 * @property string|null $PaymentValidationStatus
 * @property string|null $TrackingNumber
 * @property integer|null $TrackingNumberAmmount
 * @property string|null $BankName
 * @property string|null $BankName_formatted
 * @property string|null $AccountNumber
 * @property integer|null $Initial_TotalAmountPaid
 * @property integer|null $Final_TotalAmountPaid
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
            'id' => $this->id,
            'uuid' => $this->uuid,

            'PaymentKey' => $this->PaymentKey,
            'ReceiptNum' => $this->ReceiptNum,
            'Reference' => $this->Reference,
            'PaymentID' => $this->PaymentID,
            'DatePaid' => $this->DatePaid,
            'EmployeeCode' => $this->EmployeeCode,
            'CustomerNo' => $this->CustomerNo,
            'PaymentClass' => $this->PaymentClass,
            'OSS360_PaymentClass' => $this->OSS360_PaymentClass,
            'OSS360_PaymentType' => $this->OSS360_PaymentType,
            'HistoryDateTime' => $this->HistoryDateTime,
            'PaymentValidationStatus' => $this->PaymentValidationStatus,
            'TrackingNumber' => $this->TrackingNumber,
            'TrackingNumberAmmount' => $this->TrackingNumberAmmount,
            'BankName' => $this->BankName,
            'BankName_formatted' => $this->BankName_formatted,
            'AccountNumber' => $this->AccountNumber,
            'Initial_TotalAmountPaid' => $this->Initial_TotalAmountPaid,
            'Final_TotalAmountPaid' => $this->Final_TotalAmountPaid,

            'agence' => AgenceResource::make($this->agence),
        ];
    }
}
