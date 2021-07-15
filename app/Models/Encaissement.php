<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Encaissement
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
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
 * @property string|null $agence_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Encaissement extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $table = 'encaissements';

    #region Eloquent Relationships

    public function agence() {
        return $this->belongsTo(Agence::class, 'agence_id');
    }

    #endregion

    #region Custom functions

    public function formatBankName() {
        $this->BankName_formatted = str_replace([" BANK", " Recettes", " "], "", $this->BankName);
    }

    public function updateCheques() {
        $cheques = Cheque::where('CHEQUE_NB', $this->Reference)
            ->where('BankName_formatted', 'LIKE', $this->BankName_formatted)
            ->whereNull('encaissement_id')
            ->get();

        if ($cheques) {
            foreach ($cheques as $cheque) {
                $cheque->encaissement()->associate($this)->save();
            }
        }
    }

    #endregion

    public static function boot(){
        parent::boot();

        // Pendant enregistrement
        self::saving(function($model){
            $model->formatBankName();
        });

        // Après enregistrement
        self::saved(function($model){
            $model->updateCheques();
        });
    }
}
