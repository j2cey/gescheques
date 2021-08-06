<?php

namespace App\Models;

use PHPUnit\Util\Json;
use MongoDB\BSON\Binary;
use Illuminate\Http\Request;
use App\Traits\File\HasFiles;
use Illuminate\Support\Carbon;
use App\Traits\Report\HasReport;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\Workflow\HasWorkflowStatus;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class WorkflowExecAction
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property integer|null $workflow_exec_step_id
 * @property integer|null $workflow_action_id
 *
 * @property integer|null $user_id
 * @property string|null $username
 *
 * @property integer|null $posi
 *
 * @property string|null $model_type
 * @property integer|null $model_id
 * @property string|null $field_name
 * @property string|null $old_value
 * @property string|null $new_value
 *
 * @property string|null $save_result
 *
 * @property integer|null $BIGINT_value
 * @property binary|null $BLOB_value
 * @property boolean|null $BOOLEAN_value
 * @property string|null $CHAR_value
 * @property Carbon|null $DATETIME_value
 * @property Carbon|null $DATE_value
 * @property double|null $DECIMAL_value
 * @property double|null $DOUBLE_value
 * @property float|null $FLOAT_value
 * @property integer|null $INTEGER_value
 * @property integer|null $IPADDRESS_value
 * @property string|null $STRING_value
 * @property string|null $TEXT_value
 * @property integer|null $FILE_ref
 * @property Json $EnumType_value
 *
 * @property Json $report
 * @property integer|null $workflow_status_id
 *
 * @property Carbon|null $start_at
 * @property Carbon|null $end_at
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowExecAction extends BaseModel implements Auditable
{
    use HasFactory, HasFiles, HasWorkflowStatus, HasReport, \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    protected $with = ['fileinfos','tempfile','localfile'];

    #region Eloquent Relationships

    public function execstep() {
        return $this->belongsTo(WorkflowExecStep::class, 'workflow_exec_step_id');
    }

    /**
     * @return BelongsTo|WorkflowAction
     */
    public function action() {
        return $this->belongsTo(WorkflowAction::class, 'workflow_action_id');
    }

    public function workflowstatus() {
        return $this->belongsTo(WorkflowStatus::class, 'workflow_status_id');
    }

    public function workflowprocessstatus() {
        return $this->belongsTo(WorkflowProcessStatus::class,'workflow_process_status_id');
    }

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

    #region Custom Functions (OLD)

    public function process_old(Request $request) {
        $user = auth()->user();
        $input_vals = $request->all();

        $this->field_name = $this->action->objectfield->db_field_name;
        $this->new_value = isset($input_vals[$this->field_name]) ? $input_vals[$this->field_name] : "";

        $this->model_type = $this->execstep->exec->model_type;
        $this->model_id = $this->execstep->exec->model_id;
        $model = ($this->model_type)::where('id', $this->execstep->exec->model_id)->first();
        $this->old_value = null;

        if ($this->action->objectfield->objectfieldtype->code == "valuetype_boolean") {
            // Type Booleen
            $bool_val = ($this->new_value === "null" || $this->new_value === null || $this->new_value === "false" || $this->new_value === "") ? 0 : 1;
            $this->old_value = $model->{$this->field_name};
            $model->{$this->field_name} = $bool_val;
        } elseif ($this->action->objectfield->objectfieldtype->code == "valuetype_datetime") {
            // Type DateTime
            if (! empty($this->new_value)) {
                $this->old_value = $model->{$this->field_name};
                $model->{$this->field_name} = $this->new_value; // Carbon::parse($formInput[$action->objectfield->db_field_name]);
            }
        } elseif ($this->action->objectfield->objectfieldtype->code == "valuetype_image") {
            // Type Image
            $images_dir = $model->getFilePath();
            $this->old_value = $model->{$this->field_name};
            $model->{$this->field_name} = $model->verifyAndStoreImage($request, $this->field_name, $images_dir);
        } elseif ($this->action->objectfield->objectfieldtype->code == "valuetype_string") {
            // Type string
            $str_val = ($this->new_value === "null" || $this->new_value === null) ? "" : $this->new_value;
            $this->old_value = $model->{$this->field_name};
            $model->{$this->field_name} = $str_val;
        } elseif ($this->action->objectfield->objectfieldtype->code == "valuetype_integer") {
            // Type integer
            $str_val = ($this->new_value === "null" || $this->new_value === null || $this->new_value === null) ? 0 : (int)$this->new_value;
            $this->old_value = $model->{$this->field_name};
            $model->{$this->field_name} = $str_val;
        } else {
            $this->old_value = $model->{$this->field_name};
            $model->{$this->field_name} = $this->new_value;
        }

        $this->user_id = $user->getAuthIdentifier();
        $this->username = $user->name;

        $this->save_result = $model->save();

        $workflow_status = WorkflowStatus::where('code', "4")->first();
        $this->workflow_status_id = $workflow_status->id;

        return $this->save();
    }

    public function setFileInfos(Request $request, $fieldname_rqst) {
        $fileinfos = $this->verifyAndStoreFile($request,$fieldname_rqst, "infos_file", "temp_files_dir");
        $fileinfos->deleteRawFile();
        return $fileinfos;
    }

    #endregion

    #region Custom Functions

    public function processFromValue($value, $request_field) {
        $request_obj = new Request();
        $request_obj->setMethod('POST'); //default METHOD
        $request_obj->request->add([$request_field => $value]);

        return $this->process($request_obj);
    }

    public function process(Request $request, $request_field = null) {
        // marquer la date de début d exécution
        if ( is_null($this->start_at) ) {
            $this->setStartAt(true);
        }

        // on marque l exec d action d étape comme en cours de traitement
        $this->setWorkflowStatus('processing', true)
            ->setWorkflowProcessStatus('processing', true);

        try {

            $user = auth()->user();
            $input_vals = $request->all();

            $this->field_name = $this->action->titre;
            $request_field = is_null($request_field) ? $this->action->code : $request_field;
            $this->new_value = isset($input_vals[$request_field]) ? $input_vals[$request_field] : "";

            $this->model_type = $this->execstep->exec->model_type;
            $this->model_id = $this->execstep->exec->model_id;
            //$model = ($this->model_type)::where('id', $this->execstep->exec->model_id)->first();
            $this->old_value = null;

            $nb_processed = 0;
            $nb_failed = 0;
            $failed_msg = "";

            if ($this->action->actiontype->code === "BIGINT_value") {
                $this->BIGINT_value = intval($this->new_value);
                $nb_processed += 1;
            } elseif ($this->action->actiontype->code === "BLOB_value") {
                $this->BLOB_value = $this->new_value;
                $nb_processed += 1;
            } elseif ($this->action->actiontype->code === "BOOLEAN_value") {
                $this->BOOLEAN_value = (bool)$this->new_value;
                $nb_processed += 1;
            } elseif ($this->action->actiontype->code === "CHAR_value") {
                $this->CHAR_value = $this->new_value;
                $nb_processed += 1;
            } elseif ($this->action->actiontype->code === "DATETIME_value") {
                if (!empty($this->new_value)) {
                    $this->DATETIME_value = $this->new_value;
                }
                $nb_processed += 1;
            } elseif ($this->action->actiontype->code === "DATE_value") {
                if (!empty($this->new_value)) {
                    $this->DATE_value = $this->new_value;
                }
                $nb_processed += 1;
            } elseif ($this->action->actiontype->code === "DECIMAL_value") {
                $this->DECIMAL_value = $this->new_value;
                $nb_processed += 1;
            } elseif ($this->action->actiontype->code === "DOUBLE_value") {
                $this->DOUBLE_value = $this->new_value;
                $nb_processed += 1;
            } elseif ($this->action->actiontype->code === "FLOAT_value") {
                $this->FLOAT_value = $this->new_value;
                $nb_processed += 1;
            } elseif ($this->action->actiontype->code === "INTEGER_value") {
                $this->INTEGER_value = $this->new_value;
                $nb_processed += 1;
            } elseif ($this->action->actiontype->code === "IPADDRESS_value") {
                $this->IPADDRESS_value = $this->new_value;
                $nb_processed += 1;
            } elseif ($this->action->actiontype->code === "STRING_value") {
                $this->STRING_value = $this->new_value;
                $nb_processed += 1;
            } elseif ($this->action->actiontype->code === "TEXT_value") {
                $this->TEXT_value = $this->new_value;
                $nb_processed += 1;
            } elseif ($this->action->actiontype->code === "FILE_ref") {
                $file = $this->verifyAndStoreFile($request, $request_field, 'file', 'files_folder');
                $this->FILE_ref = $file->id;
                $nb_processed += 1;
            } elseif ($this->action->actiontype->code === "EnumType") {
                $enum_object = json_decode($this->new_value, true);
                $this->STRING_value = $enum_object['val'];
                $this->EnumType_value = $this->new_value;
                $nb_processed += 1;
            } else {
                $nb_failed += 1;
                $failed_msg = "aucune correspondance au type de donnees";
            }

            $this->user_id = $user->getAuthIdentifier();
            $this->username = $user->name;

            if ($nb_failed) {
                // on marque l exec d action d étape comme échouée
                $this->setWorkflowStatus('pending', true)
                    ->setWorkflowProcessStatus('failed', true);

                $this->addToReport(1, $failed_msg, -1, true);

                $this->save_result = -1;
            } elseif ($nb_processed === 0) {
                // on marque l exec d action d étape comme échouée
                $this->setWorkflowStatus('pending', true)
                    ->setWorkflowProcessStatus('failed', true);

                $this->addToReport(1, "aucune action exécutée", -1, true);

                $this->save_result = -1;
            } else {
                // on marque l exec d action d étape comme traitée
                $this->setWorkflowStatus('validated', true)
                    ->setWorkflowProcessStatus('processed', true);

                $this->save_result = 1;
            }

        } catch (\Exception $e) {

            // on marque l exec d action d étape comme échouée
            $this->setWorkflowStatus('pending', true)
                ->setWorkflowProcessStatus('failed', true);

            $this->addToReport(1, $e->getMessage(), -1, true);

            $this->save_result = -1;

        } finally {
            // marquer la date de fin d exécution
            if ( is_null($this->end_at) ) {
                $this->setEndAt(true);
            }
            $this->save();
            return $this;
        }
    }

    public function setTempFile(Request $request, $fieldname_rqst) {
        return $this->verifyAndStoreFile($request,$fieldname_rqst, "temp_file", "temp_files_dir");
    }

    public function setLocalFile(Request $request, $fieldname_rqst, $directory) {
        return $this->verifyAndStoreFile($request,$fieldname_rqst, "local_file", $directory);
    }

    #endregion

    public static function boot ()
    {
        parent::boot();

        // Avant création ...
        self::creating(function($model){
            // config des statuts
            $model->setWorkflowStatus('new', false)
                ->setWorkflowProcessStatus('pending', false)
            ;
        });

        // juste avant suppression
        self::deleting(function($model){
            //On supprime tous les fichiers
            $model->deleteAllFiles();
        });
    }
}
