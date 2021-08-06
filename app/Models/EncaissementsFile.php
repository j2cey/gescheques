<?php

namespace App\Models;

use App\Traits\File\HasFiles;
use Illuminate\Support\Carbon;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class EncaissementsFile
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer|null $file_import_result_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class EncaissementsFile extends BaseModel implements Auditable
{
    use HasFactory, HasFiles, \OwenIt\Auditing\Auditable;

    protected $guarded = [];
    protected $table = 'encaissements_files';

    public function fileimportresult() {
        return $this->BelongsTo(FileImportResult::class, 'file_import_result_id');
    }

    #region Relationships

    #region File

    public function fileinfos() {
        return $this->file()
            ->where('role', "infos_file");
    }

    public function tempfile() {
        return $this->file()
            ->where('role', "temp_file");
    }

    public function localfile() {
        return $this->file()
            ->where('role', "local_file");
    }

    #endregion

    #endregion

    public static function boot ()
    {
        parent::boot();

        // juste avant suppression
        self::deleting(function($model){
            //On supprime tous les fichiers
            $model->deleteAllFiles();
        });

        self::created(function ($model){
            $new_import_result = FileImportResult::create([
                'report' => json_encode([]),
            ]);
            $model->fileimportresult()->associate($new_import_result)->save();
        });
    }
}
