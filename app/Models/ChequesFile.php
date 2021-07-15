<?php

namespace App\Models;

use App\Traits\File\HasFile;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ChequesFile
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string|null $fichier
 * @property integer|null $fichier_size
 * @property string|null $fichier_type
 *
 * @property integer|null $file_import_result_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ChequesFile extends BaseModel implements Auditable
{
    use HasFactory, HasFile, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $table = 'cheques_files';

    public function fileimportresult() {
        return $this->BelongsTo(FileImportResult::class, 'file_import_result_id');
    }
}
