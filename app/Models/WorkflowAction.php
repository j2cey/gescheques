<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Traits\Image\HasImageFile;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class WorkflowAction
 * @package App\Models
 *
 * @property integer $id
 *
 * @property string $uuid
 * @property bool $is_default
 * @property string|null $tags
 * @property integer|null $status_id
 *
 * @property string $titre
 *
 * @property integer|null $workflow_action_type_id
 * @property integer|null $workflow_step_id
 * @property integer|null $workflow_object_field_id
 * @property string|null $model_type
 *
 * @property boolean $field_required
 * @property string|null $field_required_msg
 *
 * @property boolean $field_required_without
 * @property string|null $field_required_without_msg
 *
 * @property boolean $field_required_with
 * @property string|null $field_required_with_msg
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowAction extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable, HasImageFile;
    protected $guarded = [];

    public $validation_rules;
    public $validation_messages;

    #region Eloquent Relationships

    public function type() {
        return $this->belongsTo(WorkflowActionType::class, 'workflow_action_type_id');
    }

    public function step() {
        return $this->belongsTo(WorkflowStep::class, 'workflow_step_id');
    }

    public function objectfield() {
        return $this->belongsTo(WorkflowObjectField::class, 'workflow_object_field_id');
    }

    /**
     * liste des champs dont la présence rend le champs de cette action facultatif.
     */
    public function fieldsrequiredwithout() {
        return $this->belongsToMany(WorkflowObjectField::class, 'fields_required_without', 'workflow_action_id', 'workflow_object_field_id')
            ->withTimestamps()
            ;
    }

    /**
     * liste des champs dont la présence rend le champs de cette action obligatoire.
     */
    public function fieldsrequiredwith() {
        return $this->belongsToMany(WorkflowObjectField::class, 'fields_required_with', 'workflow_action_id', 'workflow_object_field_id')
            ->withTimestamps()
            ;
    }

    #endregion

    #region Validation Rules

    public static function defaultRules() {
        return [
            'titre' => 'required',
            'type' => 'required',
        ];
    }
    public static function createRules() {
        return array_merge(self::defaultRules(), [

        ]);
    }
    public static function updateRules($model) {
        return array_merge(self::defaultRules(), [

        ]);
    }

    #endregion

    #region Custom Functions

    public function setValidationRules($reset_befor = true) {
        if ($reset_befor || is_null($this->validation_rules)) {
            $this->validation_rules = [];
        }
        if ($reset_befor || is_null($this->validation_messages)) {
            $this->validation_messages = [];
        }

        if ($this->field_required_without) {
            $this->setRequiredWithoutRule();
        }
        if ($this->field_required_with) {
            $this->setRequiredWithRule();
        }

        if ( !$this->field_required_without && !$this->field_required_with && $this->field_required) {
            $this->setRequiredRule();
        }
    }

    private function setRequiredRule() {

        if ($this->field_required) {

            $validation_keys = $this->getValidationKeys();

            $this->addValidationRule('required');
            $this->addValidationRule($validation_keys['key']);
            $this->addValidationMessage($validation_keys['msg_key'], $validation_keys['msg']);

            if ($this->field_required_msg && ($this->field_required_msg !== "")) {
                $this->addValidationMessage($this->objectfield->db_field_name . '.required', $this->field_required_msg);
            }
        }
    }

    private function setRequiredWithoutRule() {
        $validation_keys = $this->getValidationKeys();
        if ($this->field_required_without) {
            $fields_list = $this->fieldsGetListName($this->fieldsrequiredwithout);
            if ($fields_list) {
                $this->addValidationRule( 'nullable' );
                $this->addValidationRule( 'required_without:' . $fields_list );
                $this->addValidationMessage( $this->objectfield->db_field_name . '.required_without', $this->field_required_without_msg);
                // validation par type (sometimes)
                $this->addValidationRule( $validation_keys['key'] );
                $this->addValidationMessage( $validation_keys['msg_key'], $validation_keys['msg'] );
            }
        }
    }
    private function setRequiredWithRule() {
        $validation_keys = $this->getValidationKeys();
        if ($this->field_required_with) {
            $fields_list = $this->fieldsGetListName($this->fieldsrequiredwith);
            if ($fields_list) {
                $this->addValidationRule( 'nullable' );
                $this->addValidationRule( 'required_with:' . $fields_list );
                $this->addValidationMessage( $this->objectfield->db_field_name . '.required_with', $this->field_required_with_msg);
                // validation par type (sometimes)
                $this->addValidationRule( $validation_keys['key'] );
                $this->addValidationMessage( $validation_keys['msg_key'], $validation_keys['msg'] );
            }
        }
    }

    /**
     * Renvoie les éléments de validation par défaut en fonction du type.
     * @return array
     */
    private function getValidationKeys() {
        $field_label = trim(explode('|',$this->objectfield->field_label)[1]);
        list($key, $msg) = "";
        if ($this->objectfield->valuetype_string) {
            // string required
            //[$key, $msg] = ["string", $field_label . " doit être une chaine de caractères"];
            list($key, $msg) = ["string", $field_label . " doit être une chaine de caractères"];
        } elseif ($this->objectfield->valuetype_integer) {
            // integer required
            //[$key, $msg] = ["integer", $field_label . " doit être un nombre"];
            list($key, $msg) = ["integer", $field_label . " doit être un nombre"];
        } elseif ($this->objectfield->valuetype_boolean) {
            // bool required
            //[$key, $msg] = ["bool", $field_label . " doit être un booléen"];
            list($key, $msg) = ["bool", $field_label . " doit être un booléen"];
        } elseif ($this->objectfield->valuetype_datetime) {
            //[$key, $msg] = ["date", $field_label . " doit être une date valide"];
            list($key, $msg) = ["date", $field_label . " doit être une date valide"];
        } elseif ($this->objectfield->valuetype_image) {
            // image required
            //[$key, $msg] = ["image", $field_label . " doit être une image valide"];
            list($key, $msg) = ["image", $field_label . " doit être une image valide"];
        } else {
            // default required
            //[$key, $msg] = ["type_non_defini", " "];
            list($key, $msg) = ["type_non_defini", " "];
        }

        return [
            // label
            'label' => $field_label,
            // validation key
            'key' => $key,
            // message key for type validation
            'msg_key' => $this->objectfield->db_field_name . "." . $key,
            // message
            'msg' => $msg,
        ];
    }

    /**
     * Ajoute une règle de validation au tableau de règles de validation
     * @param string $new_validation_rule règle
     */
    private function addValidationRule(string $new_validation_rule) {
        if ($new_validation_rule) {
            $this->validation_rules[$this->objectfield->db_field_name][] = $new_validation_rule;
        }
    }

    /**
     * Ajoute un messae de validation au tableau de messages de validation
     * @param string $new_validation_message_key clé du message
     * @param string $new_validation_message le message
     */
    private function addValidationMessage(string $new_validation_message_key, string $new_validation_message) {
        if ($new_validation_message) {
            $this->validation_messages[ $new_validation_message_key ] = $new_validation_message;
        }
    }

    private function fieldsGetListName($fields) {
        $list_name = "";
        foreach ($fields as $field) {
            if ( empty($list_name) ) {
                $list_name = $field->db_field_name;
            } else {
                $list_name = $list_name . ", " . $field->db_field_name;
            }
        }
        return $list_name;
    }

    public function Traiter(WorkflowExecModelStep $workflowexecmodelstep, $request, $images_dir) {
        $input_vals = $request->all();
        $val = isset($input_vals[$this->objectfield->db_field_name]) ? $input_vals[$this->objectfield->db_field_name] : "";
        if ($this->type->code === "2") {
            // action sur objet
            $model_type = $workflowexecmodelstep->model_type;
            $model = $model_type::where('id', $workflowexecmodelstep->model_id)->first();

            if ($this->objectfield->valuetype_boolean) {
                // Type Booleen
                $bool_val = ($val === "null" || $val === null || $val === "false" || $val === "") ? 0 : 1;
                $model->{$this->objectfield->db_field_name} = $bool_val;
            } elseif ($this->objectfield->valuetype_datetime) {
                // Type DateTime
                if (! empty($val)) {
                    $model->{$this->objectfield->db_field_name} = $val; // Carbon::parse($formInput[$action->objectfield->db_field_name]);
                }
            } elseif ($this->objectfield->valuetype_image) {
                // Type Image
                $model->{$this->objectfield->db_field_name} = $this->verifyAndStoreImage($request, $this->objectfield->db_field_name, $images_dir);
            } elseif ($this->objectfield->valuetype_string) {
                // Type string
                $str_val = ($val === "null" || $val === null) ? "" : $val;
                $model->{$this->objectfield->db_field_name} = $str_val;
            } elseif ($this->objectfield->valuetype_integer) {
                // Type integer
                $str_val = ($val === "null" || $val === null || $val === null) ? 0 : (int)$val;
                $model->{$this->objectfield->db_field_name} = $str_val;
            } else {
                $model->{$this->objectfield->db_field_name} = $val;
            }

            $model->save();

            // Marquer l'action traitée
            $affected = $this->marquerTraitee($workflowexecmodelstep->id);
            // Traiter le modelStep
            $workflowexecmodelstep->Traiter();
            return 1;
        } else {
            // action sur workflow
            return 0;
        }
    }

    public function marquerTraitee($exec_id, $rejetee = false) {
        return DB::table('model_step_actions')
            ->where('workflow_exec_model_step_id', $exec_id)
            ->where('workflow_action_id', $this->id)
            ->update([
                'traitement_effectif' => 1,
                'rejete' => $rejetee ? 1 : 0,
            ]);
    }

    #endregion

    public static function boot(){
        parent::boot();

        // Avant enregistrement
        self::saving(function($model){
            $objectfield = WorkflowObjectField::where('id', $model->workflow_object_field_id)->first();
            $object = WorkflowObject::where('id', $objectfield->workflow_object_id)->first();
            $model->model_type = $object->model_type;
        });
    }
}
