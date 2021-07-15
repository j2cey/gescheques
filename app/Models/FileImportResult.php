<?php

namespace App\Models;

use PHPUnit\Util\Json;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class FileImportResult
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property boolean $imported
 *
 * @property Carbon $importstart_at
 * @property Carbon $importend_at
 *
 * @property integer $nb_rows
 * @property boolean $import_processing
 * @property integer $nb_rows_success
 * @property integer $nb_rows_failed
 * @property integer $nb_rows_processing
 * @property integer $nb_rows_processed
 *
 * @property string $row_last_processed
 * @property integer $nb_try
 * @property Json $report
 *
 * @property Carbon $suspended_at
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class FileImportResult extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    public function encaissementsfile() {
        return $this->hasOne(EncaissementsFile::class, 'file_import_result_id');
    }

    public function chequesfile() {
        return $this->hasOne(ChequesFile::class, 'file_import_result_id');
    }
}
