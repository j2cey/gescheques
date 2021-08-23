<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Traits\File\HasFiles;
use Illuminate\Support\Carbon;
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
 * @property string $code
 *
 * @property integer|null $workflow_step_id
 * @property integer|null $workflow_action_type_id
 * @property integer|null $workflow_treatment_type_id
 * @property integer|null $enum_type_id
 *
 * @property integer|null $workflow_object_field_id
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
 * @property WorkflowTreatmentType treatmenttype
 */
class WorkflowAction extends BaseModel implements Auditable
{
    use HasFactory, HasFiles, \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    public $validation_rules;
    public $validation_messages;


    #region Validation Rules

    public static function defaultRules() {
        return [
            'titre' => 'required',
            'actiontype' => 'required',
            'field_required_msg' => 'required_unless:field_required,0',
            'field_required_without_msg' => 'required_unless:field_required_without,0',
            'actionsrequiredwithout' => 'required_unless:field_required_without,0',
            'field_required_with_msg' => 'required_unless:field_required_with,0',
            'actionsrequiredwith' => 'required_unless:field_required_with,0',
            'mimetypes' => 'required_if:actiontype.code,FILE_ref',
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
    public static function messagesRules() {
        return [
            'titre.required' => 'Prière de Renseigner le Titre',
            'actiontype.required' => 'Le type d action est requis',
            'field_required_msg.required_unless' => 'Renseignez un message d erreur',
            'field_required_without_msg.required_unless' => 'Renseignez un message d erreur',
            'actionsrequiredwithout.required_unless' => 'Selectionnez les actions concernées',
            'field_required_with_msg.required_unless' => 'Renseignez un message d erreur',
            'actionsrequiredwith.required_unless' => 'Selectionnez les actions concernées',
            'mimetypes.required_if' => 'Selectionnez le(s) type(s) de fichier',
        ];
    }

    #endregion

    #region Eloquent Relationships

    public function workflowstep() {
        return $this->belongsTo(WorkflowStep::class, 'workflow_step_id');
    }

    public function actiontype() {
        return $this->belongsTo(WorkflowActionType::class, 'workflow_action_type_id');
    }

    public function treatmenttype() {
        return $this->belongsTo(WorkflowTreatmentType::class, 'workflow_treatment_type_id');
    }

    public function enumtype() {
        return $this->belongsTo(EnumType::class, 'enum_type_id');
    }

    public function mimetypes()
    {
        return $this->belongsToMany(MimeType::class);
    }

    public function actionsrequiredwithout() {
        return $this->belongsToMany(WorkflowAction::class, 'actions_required_without', 'main_workflow_action_id', 'workflow_action_id')
            ->withTimestamps()
            ;
    }

    public function actionsrequiredwith() {
        return $this->belongsToMany(WorkflowAction::class, 'actions_required_with', 'main_workflow_action_id', 'workflow_action_id')
            ->withTimestamps()
            ;
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

    #region Scopes

    public function scopeTreatmentType($query, $treatment_type) {
        return $query->where('workflow_treatment_type_id', $treatment_type->id);
    }

    public function scopeTreatmentTypePass($query) {
        return $this->scopeTreatmentType($query, WorkflowTreatmentType::getPassType());
    }

    public function scopeTreatmentTypeReject($query) {
        return $this->scopeTreatmentType($query, WorkflowTreatmentType::getRejectType());
    }

    public function scopeTreatmentTypeExpire($query) {
        return $this->scopeTreatmentType($query, WorkflowTreatmentType::getExpireType());
    }

    public function scopeTreatmentTypeAllways($query) {
        return $this->scopeTreatmentType($query, WorkflowTreatmentType::getAllwaysType());
    }

    #endregion

    #region Custom Functions - CRUD

    public static function createNew($titre, $description, $workflowstep = null, $actiontype = null, $code = null): WorkflowAction {
        $action = WorkflowAction::create([
            'titre' => $titre,
            'code' => is_null($code) ? Str::slug('wf_action_' . (string)Str::orderedUuid(), "_" ) : $code,
            'description' => $description,
        ]);

        if( ! is_null($workflowstep) ) $action->setStep($workflowstep, false);
        if( ! is_null($actiontype) ) $action->setActionType($actiontype, false);

        $action->save();

        return $action;
    }

    #region Validation Action

    public static function createValidationAction($titre, $description, $workflowstep = null, $actiontype = null, $code = null) : WorkflowAction {

        $action = self::createNew($titre, $description, $workflowstep, $actiontype, $code)
            ->setValidationTreatmentType(true)
        ;

        return $action;
    }

    public static function createValidationFileAction($titre, $description, $workflowstep = null, $code = null) : WorkflowAction {
        $file_type = WorkflowActionType::where('code', "FILE_ref")->first();
        $mime_types_ids = MimeType::defaultFileMimeTypes();
        return self::createNew($titre, $description, $workflowstep, $file_type, $code)
            ->setValidationTreatmentType(true)
            ->setMimeTypes($mime_types_ids, true)
        ;
    }

    #endregion

    #region Rejection Action

    public static function createRejectionAction($titre, $description, $workflowstep = null, $actiontype = null, $code = null) : WorkflowAction {

        $action = self::createNew($titre, $description, $workflowstep, $actiontype, $code)
            ->setRejectionTreatmentType(true)
        ;

        return $action;
    }

    public static function createRejectionEnumTypeAction($enum_name, array $enum_values, $titre, $description, $workflowstep = null, $code = null) : WorkflowAction {

        $enum_type = WorkflowActionType::where('code', "EnumType")->first();

        $action_enumtype = EnumType::createNew($enum_name)
            ->addValues($enum_values)
        ;

        return self::createNew($titre, $description, $workflowstep, $enum_type, $code)
            ->setRejectionTreatmentType(true)
            ->setEnumType($action_enumtype, true)
        ;
    }

    #endregion

    public static function createExpirationAction($titre, $description, $workflowstep = null, $actiontype = null, $code = null) : WorkflowAction {

        $action = self::createNew($titre, $description, $workflowstep, $actiontype, $code)
            ->setExpirationTreatmentType(true)
        ;

        return $action;
    }

    public function setStep(WorkflowStep $workflow_step = null, $save = true) {
        if ( is_null($workflow_step) ) {
            $this->workflowstep()->disassociate();
        } else {
            $this->workflowstep()->associate($workflow_step);
        }

        if ($save) { $this->save(); }

        return $this;
    }

    public function setActionType(WorkflowActionType $workflow_action_type = null, $save = true) {
        if ( is_null($workflow_action_type) ) {
            $this->actiontype()->disassociate();
        } else {
            $this->actiontype()->associate($workflow_action_type);
        }

        if ($save) { $this->save(); }

        return $this;
    }

    public function setTreatmentType(WorkflowTreatmentType $workflow_treatment_type = null, $save = true) {
        if ( is_null($workflow_treatment_type) ) {
            $this->treatmenttype()->disassociate();
        } else {
            $this->treatmenttype()->associate($workflow_treatment_type);
        }

        if ($save) { $this->save(); }

        return $this;
    }

    public function setRequired($field_required, $field_required_msg, $save = true) {
        if ( is_null($field_required) || ( ! $field_required ) ) {
            $this->field_required = 0;
            $this->field_required_msg = null;
        } else {
            $this->field_required = 1;
            $this->field_required_msg = $field_required_msg;
        }
        if ($save) { $this->save(); }

        return $this;
    }

    public function setRequiredWithout($field_required_without, $actionsrequiredwithout, $field_required_without_msg, $save = true) {
        if ( is_null($field_required_without) || ( ! $field_required_without ) ) {
            $this->field_required_without = 0;
            $this->field_required_without_msg = null;
        } else {
            $this->field_required_without = 1;
            $this->field_required_without_msg = $field_required_without_msg;
            $this->actionsrequiredwithout()->sync($actionsrequiredwithout);
        }
        if ($save) { $this->save(); }

        return $this;
    }

    public function setRequiredWith($field_required_with, $actionsrequiredwith, $field_required_with_msg, $save = true) {
        if ( is_null($field_required_with) || ( ! $field_required_with ) ) {
            $this->field_required_with = 0;
            $this->field_required_with_msg = null;
        } else {
            $this->field_required_with = 1;
            $this->field_required_with_msg = $field_required_with_msg;
            $this->actionsrequiredwith()->sync($actionsrequiredwith);
        }
        if ($save) { $this->save(); }

        return $this;
    }

    public function setMimeTypes($mimetypes, $save = true) : WorkflowAction {
        if ( is_null($mimetypes) || ( empty($mimetypes) ) ) {
            $this->mimetypes()->detach();
        } else {
            $this->mimetypes()->sync($mimetypes);
        }
        if ($save) { $this->save(); }

        return $this;
    }

    public function setEnumType(EnumType $enum_value = null, $save = true) : WorkflowAction {
        if ( is_null($enum_value) ) {
            $this->enumtype()->disassociate();
        } else {
            $this->enumtype()->associate($enum_value);
        }

        if ($save) { $this->save(); }

        return $this;
    }

    public function setValidationTreatmentType($save = true) {
        $validation_treatment_type = WorkflowTreatmentType::getPassType();
        if ( $validation_treatment_type) {
            $this->setTreatmentType($validation_treatment_type, $save);
            if ($save) { $this->save(); }
        }

        return $this;
    }

    public function setRejectionTreatmentType($save = true) {
        $rejection_treatment_type = WorkflowTreatmentType::getRejectType();
        if ( $rejection_treatment_type) {
            $this->setTreatmentType($rejection_treatment_type, $save);
            if ($save) { $this->save(); }
        }

        return $this;
    }

    public function setExpirationTreatmentType($save = true) {
        $expiration_treatment_type = WorkflowTreatmentType::getExpireType();
        if ( $expiration_treatment_type) {
            $this->setTreatmentType($expiration_treatment_type, $save);
            if ($save) { $this->save(); }
        }

        return $this;
    }

    #endregion

    #region Custom Functions - Exec

    public function launch($exec_step) : ?WorkflowExecAction {
        // si l action est active
        if ($this->status->code == "active") {
            $unprocessable_status_ids = WorkflowStatus::whereIn('code', ['validated', 'rejected'])->get()->pluck('id')->toArray();
            $execaction = WorkflowExecAction::where('workflow_exec_step_id', $exec_step->id)
                ->where('workflow_action_id', $this->id)
                ->whereNotIn('workflow_status_id', $unprocessable_status_ids)
                ->first();
            if ($execaction) {
                return $execaction;
            } else {
                $execaction = WorkflowExecAction::create([
                    'workflow_exec_step_id' => $exec_step->id,
                    'workflow_action_id' => $this->id,
                    'posi' => WorkflowExecAction::where('workflow_exec_step_id', $exec_step->id)->count() + 1,
                    'report' => json_encode([]),
                    'EnumType_value' => json_encode([]),
                ]);

                return $execaction;
            }
        } else {
            return null;
        }
    }

    #endregion

    #region Custom Functions - Exec Validations

    public function addToEnumTypeList($arr) {
        if ($this->actiontype->code === "EnumType") {
            $arr[$this->code] = $this->enumtype->enumvalues;
        }

        return $arr;
    }

    public function addToArrayAssoc($arr) {
        if ($this->actiontype->code === "BIGINT_value") {
            $arr[$this->code] = "";
        } elseif ($this->actiontype->code === "BLOB_value") {
            $arr[$this->code] = "";
        } elseif ($this->actiontype->code === "BOOLEAN_value") {
            $arr[$this->code] = "";
        } elseif ($this->actiontype->code === "CHAR_value") {
            $arr[$this->code] = "";
        } elseif ($this->actiontype->code === "DATETIME_value") {
            $arr[$this->code] = "";
        } elseif ($this->actiontype->code === "DATE_value") {
            $arr[$this->code] = "";
        } elseif ($this->actiontype->code === "DECIMAL_value") {
            $arr[$this->code] = "";
        } elseif ($this->actiontype->code === "DOUBLE_value") {
            $arr[$this->code] = "";
        } elseif ($this->actiontype->code === "FLOAT_value") {
            $arr[$this->code] = "";
        } elseif ($this->actiontype->code === "INTEGER_value") {
            $arr[$this->code] = "";
        } elseif ($this->actiontype->code === "IPADDRESS_value") {
            $arr[$this->code] = "";
        } elseif ($this->actiontype->code === "STRING_value") {
            $arr[$this->code] = "";
        } elseif ($this->actiontype->code === "TEXT_value") {
            $arr[$this->code] = "";
        } elseif ($this->actiontype->code === "Enum_ref") {
            $arr[$this->code] = "";
        } elseif ($this->actiontype->code === "EnumType") {
            $arr[$this->code] = "";
        }

        return $arr;
    }

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

        $this->setMimeTypesRule();
        $this->setFileMaxRule();
    }

    private function setRequiredRule() {
        // TODO: Valider les enumType
        if ($this->field_required && $this->actiontype->code !== "EnumType") {

            $validation_keys = $this->getValidationKeys();

            $this->addValidationRule('required');
            $this->addValidationRule($validation_keys['key']);
            $this->addValidationMessage($validation_keys['msg_key'], $validation_keys['msg']);

            if ($this->field_required_msg && ($this->field_required_msg !== "")) {
                $this->addValidationMessage($this->code . '.required', $this->field_required_msg);
            }
        }
    }

    private function setRequiredWithoutRule() {
        $validation_keys = $this->getValidationKeys();
        if ($this->field_required_without) {
            $fields_list = $this->fieldsGetListName($this->actionsrequiredwithout, "code");
            if ($fields_list) {
                $this->addValidationRule( 'nullable' );
                $this->addValidationRule( 'required_without:' . $fields_list );
                $this->addValidationMessage( $this->code . '.required_without', $this->field_required_without_msg);
                // validation par type (sometimes)
                $this->addValidationRule( $validation_keys['key'] );
                $this->addValidationMessage( $validation_keys['msg_key'], $validation_keys['msg'] );
            }
        }
    }
    private function setRequiredWithRule() {
        $validation_keys = $this->getValidationKeys();
        if ($this->field_required_with) {
            $fields_list = $this->fieldsGetListName($this->actionsrequiredwith, "code");
            if ($fields_list) {
                $this->addValidationRule( 'nullable' );
                $this->addValidationRule( 'required_with:' . $fields_list );
                $this->addValidationMessage( $this->code . '.required_with', $this->field_required_with_msg);
                // validation par type (sometimes)
                $this->addValidationRule( $validation_keys['key'] );
                $this->addValidationMessage( $validation_keys['msg_key'], $validation_keys['msg'] );
            }
        }
    }
    private function setMimeTypesRule() {
        if ($this->actiontype->code === "FILE_ref") {
            $fields_list = $this->fieldsGetListName($this->mimetypes, "extension");
            $field_label = $this->code;
            list($key, $msg) = ["mimes", "le fichier dois etre d un des types: " . $fields_list];
            $validation_keys = [
                // label
                'label' => $field_label,
                // validation key
                'key' => $key,
                // message key for type validation
                'msg_key' => $this->code . "." . $key,
                // message
                'msg' => $msg,
            ];
            if ($fields_list) {
                if ( ! $this-$this->field_required ) {
                    // rendre le champs nullable s'il n'est pas requis
                    $this->addValidationRule( 'nullable' );
                }
                $this->addValidationRule( 'mimes:' . $fields_list );
                $this->addValidationMessage( $this->code . '.mimes', $validation_keys['msg']);
            }
        }
    }

    private function setFileMaxRule() {
        if ($this->actiontype->code === "FILE_ref") {
            $file_upload_max_size_ko = WorkflowAction::getFileUploadMaxSize("ko");
            $file_upload_max_size_mo = WorkflowAction::getFileUploadMaxSize("Mo");

            if ($file_upload_max_size_ko) {
                $field_label = $this->code;
                list($key, $msg) = ["max", "la taille du fichier doit etre de " . $file_upload_max_size_mo . ' Mo max'];
                $validation_keys = [
                    // label
                    'label' => $field_label,
                    // validation key
                    'key' => $key,
                    // message key for type validation
                    'msg_key' => $this->code . "." . $key,
                    // message
                    'msg' => $msg,
                ];
                $this->addValidationRule('max:' . $file_upload_max_size_ko);
                $this->addValidationMessage($this->code . '.max', $validation_keys['msg']);
            }
        }
    }

    /**
     * Renvoie les éléments de validation par défaut en fonction du type.
     * @return array
     */
    private function getValidationKeys() {
        $field_label = $this->code;
        list($key, $msg) = "";

        if ($this->actiontype->code === "BIGINT_value") {
            // integer required
            list($key, $msg) = ["integer", "veuillez renseigner un nombre entier (grande taille) valide"];
        } elseif ($this->actiontype->code === "BLOB_value") {
            // blob required
            list($key, $msg) = ["string", "veuillez renseigner une chaine de caractères (BLOB)"];
        } elseif ($this->actiontype->code === "BOOLEAN_value") {
            // bool required
            list($key, $msg) = ["bool", "veuillez renseigner un booléen"];
        } elseif ($this->actiontype->code === "CHAR_value") {
            // string required
            list($key, $msg) = ["string", "veuillez renseigner une chaine de caractères (CHAR)"];
        } elseif ($this->actiontype->code === "DATETIME_value") {
            // date required
            list($key, $msg) = ["date", "veuillez renseigner une date (et heure) valide"];
        } elseif ($this->actiontype->code === "DATE_value") {
            // date required
            list($key, $msg) = ["date", "veuillez renseigner une date valide"];
        } elseif ($this->actiontype->code === "DECIMAL_value") {
            // numeric required
            list($key, $msg) = ["numeric", "veuillez renseigner un nombre décimal valide"];
        } elseif ($this->actiontype->code === "DOUBLE_value") {
            // numeric required
            list($key, $msg) = ["numeric", "veuillez renseigner un nombre décimal valide (DOUBLE)"];
        } elseif ($this->actiontype->code === "FLOAT_value") {
            // numeric required
            list($key, $msg) = ["numeric", "veuillez renseigner un nombre décimal valide (FLOAT)"];
        } elseif ($this->actiontype->code === "INTEGER_value") {
            // integer required
            list($key, $msg) = ["integer", "veuillez renseigner un nombre entier valide"];
        } elseif ($this->actiontype->code === "IPADDRESS_value") {
            // ip required
            list($key, $msg) = ["ip", "veuillez renseigner une adresse IP valide"];
        } elseif ($this->actiontype->code === "STRING_value") {
            // string required
            list($key, $msg) = ["string", "veuillez renseigner une chaine de caractères"];
        } elseif ($this->actiontype->code === "TEXT_value") {
            // string required
            list($key, $msg) = ["string", "veuillez renseigner un text valide"];
        } elseif ($this->actiontype->code === "FILE_ref") {
            // file required
            list($key, $msg) = ["file", "veuillez renseigner un fichier valide"];
        }

        return [
            // label
            'label' => $field_label,
            // validation key
            'key' => $key,
            // message key for type validation
            'msg_key' => $this->code . "." . $key,
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
            $this->validation_rules[$this->code][] = $new_validation_rule;
        }
    }

    /**
     * Ajoute un messae de validation au tableau de messages de validation
     * @param string $new_validation_message_key clé du message
     * @param string $new_validation_message le message
     */
    private function addValidationMessage($new_validation_message_key, $new_validation_message) {
        if ($new_validation_message) {
            $this->validation_messages[ $new_validation_message_key ] = $new_validation_message;
        }
    }

    private function fieldsGetListName($fields, $field_name) {
        $list_name = "";
        foreach ($fields as $field) {
            if ( empty($list_name) ) {
                $list_name = $field->{$field_name};
            } else {
                $list_name = $list_name . "," . $field->{$field_name};
            }
        }
        return $list_name;
    }

    #endregion

    public static function boot(){
        parent::boot();

        // Avant enregistrement
        self::saving(function($model){
            //$objectfield = WorkflowObjectField::where('id', $model->workflow_object_field_id)->first();
            //$object = WorkflowObject::where('id', $objectfield->workflow_object_id)->first();
            //$model->model_type = $object->model_type;
        });
    }
}
