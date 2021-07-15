<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Traits\Image\HasImageFile;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Cheque
 * @package App\Models
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string|null $NREC_BANK_MVT_ID
 * @property string|null $ACC_CODE
 * @property string|null $BANK_FLOW_CODE
 * @property string|null $ABK_CUR_AMOUNT
 * @property string|null $ABK_CUR_CODE
 * @property string|null $TRN_FLAG
 * @property string|null $TRN_AMOUNT
 * @property string|null $TRN_CUR
 * @property string|null $CHEQUE_NB
 * @property string|null $BOOK_DATE
 * @property string|null $VALUE_DATE
 * @property string|null $DESCRIPTION
 * @property string|null $COMPLEMENTS1
 * @property string|null $COMPLEMENTS2
 * @property string|null $COMPLEMENTS3
 * @property string|null $COMPLEMENTS4
 * @property string|null $COMPLEMENTS5
 * @property string|null $COMPLEMENTS6
 * @property string|null $COMPLEMENTS7
 * @property string|null $COMPLEMENTS8
 * @property string|null $COMPLEMENTS9
 * @property string|null $COMPLEMENTS10
 * @property string|null $COMPLEMENTS11
 * @property string|null $COMPLEMENTS12
 * @property string|null $COMPLEMENTS13
 * @property string|null $COMPLEMENTS14
 * @property string|null $COMPLEMENTS15
 * @property string|null $COMPLEMENTS16
 * @property string|null $COMPLEMENTS17
 * @property string|null $COMPLEMENTS18
 * @property string|null $COMPLEMENTS19
 * @property string|null $COMPLEMENTS20
 * @property string|null $COMPLEMENTS21
 * @property string|null $COMPLEMENTS22
 * @property string|null $COMPLEMENTS23
 * @property string|null $COMPLEMENTS24
 * @property string|null $SENSE_FLAG
 * @property string|null $EURO_GAP_FLAG
 * @property string|null $BANK_CUR_AMOUNT
 * @property string|null $BANK_CUR_CODE
 * @property string|null $INTERNAL_MVT_ID
 * @property string|null $IMPORT_PROCESS_LOG_ID
 * @property string|null $IMPORT_DATE
 * @property string|null $HISTORY_ID
 * @property string|null $CALCULATION_METHOD
 * @property string|null $EXEMPT_FLAG
 * @property string|null $EXTRACT_FLAG
 * @property string|null $PRE_REC_ID
 * @property string|null $UNREC_DATE
 * @property string|null $REC_TEMP_FLAG
 * @property string|null $NOT_DIRTY_FLAG
 * @property string|null $ZU_01
 * @property string|null $ZU_02
 * @property string|null $ZU_03
 * @property string|null $ZU_04
 * @property string|null $ZU_05
 * @property string|null $ZU_06
 * @property string|null $ZU_07
 * @property string|null $ZU_08
 * @property string|null $ZU_09
 * @property string|null $ZU_10
 * @property string|null $ROWVERSION
 * @property string|null $BankName_formatted
 *
 * @property string|null $scan_cheque
 *
 * @property integer|null $bordereau_id
 * @property integer|null $encaissement_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Cheque extends BaseWorkflowable implements Auditable
{
    use HasFactory, HasImageFile, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $table = 'cheques';

    #region Eloquent Relationships

    public function bordereau() {
        return $this->belongsTo(Bordereau::class);
    }

    public function encaissement() {
        return $this->belongsTo(Encaissement::class, 'encaissement_id');
    }

    #endregion

    #region Custom Functions

    public function updateEncaissement() {
        if ($this->encaissement) {
            return 1;
        } else {
            $encaissement = Encaissement::where('Reference', $this->CHEQUE_NB)
                ->where('BankName_formatted', 'LIKE', $this->BankName_formatted)->first();

            if ($encaissement) {
                $this->encaissement()->associate($encaissement)->save();
            }
        }
    }

    public function formatBankName() {
        $this->BankName_formatted = str_replace(["REC   ","ARIS  "," BANK", " Recettes", " "], "", $this->ACC_CODE);
    }

    #endregion

    #region HasWorkflow implementation

    public function getFilePath(): string
    {
        return "cheques_scans";
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
            $model->updateEncaissement();
        });
    }
}
