<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Rules\StepCanExpire;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * Class WorkflowStep
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
 * @property integer $posi
 * @property string|null $description
 *
 * @property integer|null $workflow_id
 * @property string $code
 *
 * @property boolean $role_static
 *
 * @property boolean $role_dynamic
 * @property string|null $role_dynamic_label
 * @property string|null $role_dynamic_previous_label
 *
 * @property boolean $role_previous
 *
 * @property boolean $can_expire
 * @property integer| $expire_hours
 * @property integer| $expire_days
 *
 * @property boolean $notify_to_approvers
 * @property boolean $notify_to_others
 *
 * @property integer|null $step_parent_id
 * @property integer|null $workflow_step_type_id
 *
 * @property string|null $stylingClass
 * @property integer|null $flowchart_position_x
 * @property integer|null $flowchart_position_y
 * @property integer|null $flowchart_size_width
 * @property integer|null $flowchart_size_height
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property WorkflowStep|null $transitionpassstep
 * @property WorkflowStep|null $transitionrejectstep
 * @property WorkflowStep|null $transitionexpirestep
 * @property WorkflowStep|null $transitionallwaysstep
 * @property Role[] $effectiveapprovers
 * @property WorkflowStepTransition[]|null $transitions
 * @property WorkflowAction[] $rejectionactions
 * @property WorkflowAction[] $actions
 * @property WorkflowStep[]|null $staticapprovers
 * @property WorkflowStepType $type
 * @property Workflow $workflow
 * @property User[] $otherstonotify
 */
class WorkflowStep extends BaseModel implements Auditable
{
    private ?WorkflowTreatmentType $treatmenttype_pass = null;
    private ?WorkflowTreatmentType $treatmenttype_reject = null;
    private ?WorkflowTreatmentType $treatmenttype_expire = null;
    private ?WorkflowTreatmentType $treatmenttype_allways = null;


    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->treatmenttype_pass = WorkflowTreatmentType::getPassType();
        $this->treatmenttype_reject = WorkflowTreatmentType::getRejectType();
        $this->treatmenttype_expire = WorkflowTreatmentType::getExpireType();
        $this->treatmenttype_allways = WorkflowTreatmentType::getAllwaysType();
    }

    #region Eloquent Relationships

    public function workflow() {
        return $this->belongsTo(Workflow::class);
    }

    public function type() {
        return $this->belongsTo(WorkflowStepType::class, 'workflow_step_type_id');
    }

    public function stepparent() {
        return $this->belongsTo(WorkflowStep::class, 'step_parent_id');
    }

    public function staticapprovers() {
        return $this->belongsToMany(Role::class, 'role_workflow_step', 'workflow_step_id', 'role_id');
    }

    #region actions

    public function actions() {
        return $this->hasMany(WorkflowAction::class, 'workflow_step_id');
    }

    public function actionspass() {
        return $this->actions()->TreatmentTypePass();
        /*return $this->hasMany(WorkflowAction::class)
            ->where('workflow_treatment_type_id', $this->treatmenttype_pass->id);*/
    }

    public function actionsreject() {
        return $this->actions()->TreatmentTypeReject();
        /*return $this->hasMany(WorkflowAction::class)
            ->where('workflow_treatment_type_id', $this->treatmenttype_reject->id);*/
    }

    public function actionsexpire() {
        return $this->actions()->TreatmentTypeExpire();
        /*return $this->hasMany(WorkflowAction::class)
            ->where('workflow_treatment_type_id', $this->treatmenttype_expire->id);*/
    }

    public function actionsallways() {
        return $this->actions()->TreatmentTypeAllways();
    }

    #endregion

    #region transitions

    /**
     * Liste des transitions possibles pour l étape
     * @return HasMany
     */
    public function transitions() {
        return $this->hasMany(WorkflowStepTransition::class,'workflow_step_source_id');
    }

    /**
     * Transition en cas de validation/approbation (pass)
     * @return HasOne
     */
    public function transitionpass() {
        return $this->hasOne(WorkflowStepTransition::class,'workflow_step_source_id')
            ->where('workflow_treatment_type_id', $this->treatmenttype_pass->id)
            ->latest()
            ;
    }

    /**
     * Etape suivante après un traitement validé/approuvé (pass)
     * @return HasOneThrough
     */
    public function transitionpassstep() {
        return $this->hasOneThrough(WorkflowStep::class, WorkflowStepTransition::class,'workflow_step_source_id', 'id', 'id', 'workflow_step_destination_id')
            ->where('workflow_treatment_type_id', $this->treatmenttype_pass->id)
            ->orWhere('workflow_treatment_type_id', $this->treatmenttype_allways->id)
            ->latest()
            ;
    }

    /**
     * Transition en cas de réjet (reject)
     * @return HasOne
     */
    public function transitionreject() {
        return $this->hasOne(WorkflowStepTransition::class,'workflow_step_target_id', 'workflow_step_source_id')
            ->where('workflow_treatment_type_id', $this->treatmenttype_reject->id)
            ->latest()
            ;
    }

    /**
     * Etape suivante après un traitement rejété (pass)
     * @return HasOneThrough
     */
    public function transitionrejectstep() {
        return $this->hasOneThrough(WorkflowStep::class, WorkflowStepTransition::class, 'workflow_step_source_id', 'id', 'id', 'workflow_step_destination_id')
            ->where('workflow_treatment_type_id', $this->treatmenttype_reject->id)
            ->orWhere('workflow_treatment_type_id', $this->treatmenttype_allways->id)
            ->latest()
            ;
    }

    /**
     * Transition en cas d expiration (expire)
     * @return HasOne
     */
    public function transitionexpire() {
        return $this->hasOne(WorkflowStepTransition::class,'workflow_step_source_id')
            ->where('workflow_treatment_type_id', $this->treatmenttype_expire->id)
            ->latest()
            ;
    }

    /**
     * Etape suivante après expiration de l étape (expire)
     * @return HasOneThrough
     */
    public function transitionexpirestep() {
        return $this->hasOneThrough(WorkflowStep::class, WorkflowStepTransition::class, 'workflow_step_source_id', 'id', 'id', 'workflow_step_destination_id')
            ->where('workflow_treatment_type_id', $this->treatmenttype_expire->id)
            ->orWhere('workflow_treatment_type_id', $this->treatmenttype_allways->id)
            ->latest()
            ;
    }

    /**
     * Transition dans tous les cas (allways)
     * @return HasOne
     */
    public function transitionallways() {
        return $this->hasOne(WorkflowStepTransition::class,'workflow_step_source_id')
            ->where('workflow_treatment_type_id', $this->treatmenttype_allways->id)
            ->latest()
            ;
    }

    /**
     * Etape suivante dans tous les cas (allways)
     * @return HasOneThrough
     */
    public function transitionallwaysstep() {
        return $this->hasOneThrough(WorkflowStep::class, WorkflowStepTransition::class, 'workflow_step_source_id', 'id', 'id', 'workflow_step_destination_id')
            ->where('workflow_treatment_type_id', $this->treatmenttype_allways->id)
            ->latest()
            ;
    }

    #endregion

    public function otherstonotify() {
        return $this->belongsToMany(User::class, 'workflowstep_others_to_notify', 'workflow_step_id', 'user_id')
            ->withTimestamps();
    }


    #endregion

    #region Validation Rules

    public static function defaultRules($can_expire,$expire_hours,$expire_days) {
        return [
            'titre' => 'required',
            'staticapprovers' => 'required_unless:role_static,0',
            'transitionpassstep' => 'required',
            'transitionrejectstep' => 'required',
            'role_dynamic_label' => 'required_unless:role_dynamic,0',
            'role_dynamic_previous_label' => 'required_unless:role_dynamic,0',
            'expire_hours' => [ new StepCanExpire($can_expire,$expire_hours,$expire_days) ],
            'expire_days' => [ new StepCanExpire($can_expire,$expire_hours,$expire_days) ],
            'transitionexpirestep' => 'required_unless:can_expire,0',
            'otherstonotify' => 'required_unless:notify_to_others,0',
        ];
    }
    public static function createRules($can_expire,$expire_hours,$expire_days) {
        return array_merge(self::defaultRules($can_expire,$expire_hours,$expire_days), [

        ]);
    }
    public static function updateRules($model,$can_expire,$expire_hours,$expire_days) {
        return array_merge(self::defaultRules($can_expire,$expire_hours,$expire_days), [

        ]);
    }
    // TODO: manage min & max values for x, y, width & height
    public static function updateFlowchartNodeRules($model) {
        return [
            'flowchart_position_x' => 'nullable|numeric',
            'flowchart_position_y' => 'nullable|numeric',
            'flowchart_size_width' => 'nullable|numeric|min:100',
            'flowchart_size_height' => 'nullable|numeric|min:50',
        ];
    }

    public static function messagesRules() {
        return [
            'titre.required' => 'Prière de Renseigner le Titre',
            'transitionpassstep.required' => 'Une étape après validation est requise',
            'transitionrejectstep.required' => 'Une étape après réjet est requise',
            'staticapprovers.required_unless' => 'Sélectionnez au moins un profile',
            'role_dynamic_label.required_unless' => 'Renseignez un libellé pour le(s) profile(s) dynamique',
            'role_dynamic_previous_label.required_unless' => 'Renseignez un libellé pour le(s) profile(s) précédent(s)',
            'transitionexpirestep.required_unless' => 'Selectionnez l étape à suivre après expiration',
            'otherstonotify.required_unless' => 'Selectionnez le(les) utilisateur(s) à notifier',
            'flowchart_position_x.numeric' => 'La position X doit etre un nombre vallable',
            'flowchart_position_y.numeric' => 'La position Y doit etre un nombre vallable',
            'flowchart_size_width.numeric' => 'La Largeur du Box doit etre un nombre vallable',
            'flowchart_size_width.min' => 'La Largeur minimum du Box est 100',
            'flowchart_size_height.numeric' => 'La Hauteur du Box doit etre un nombre vallable',
            'flowchart_size_height.min' => 'La Hauteur minimum du Box est 50',
        ];
    }

    #endregion

    #region Scopes

    public function scopeCoded($query, $code) {
        return $query
            ->where('code', $code)
            ;
    }

    #endregion

    #region Custom Functions - CRUD

    /**
     * Crée et retourne une nouvelle étape de workflow
     * @param $titre
     * @param $code
     * @param $description
     * @param Workflow|null $workflow
     * @param WorkflowStep|null $validated_nextstep
     * @param WorkflowStep|null $rejected_nextstep
     * @return WorkflowStep
     */
    public static function createNew($titre, $description, $stylingClass, $workflow = null, $code = null, $validated_nextstep = null, $rejected_nextstep = null): WorkflowStep {
        $posi = is_null($workflow) ? 0 : WorkflowStep::where('workflow_id', $workflow->id)
            ->where('posi', '>', -1)
            ->count('id');
        $code = self::getCode($code, $workflow, $posi);
        $step = WorkflowStep::create([
            'titre' => $titre,
            'description' => $description,
            'stylingClass' => $stylingClass,
            'posi' => $posi,
            'code' => $code,
        ]);

        if( ! is_null($validated_nextstep) ) $step->setNextStepAfterValidated($validated_nextstep, false);
        if( ! is_null($rejected_nextstep) ) $step->setNextStepAfterRejected($rejected_nextstep, false);

        if( ! is_null($workflow) ) $step->workflow_id = $workflow->id;
        if( ! is_null($validated_nextstep) ) $step->validated_nextstep_id = $validated_nextstep->id;
        if( ! is_null($rejected_nextstep) ) $step->rejected_nextstep_id = $rejected_nextstep->id;

        $step->save();

        return $step;
    }

    private static function getCode($code, $workflow, $posi) {
        return is_null($code) ? ( is_null($workflow) ? Str::slug( (string)Str::orderedUuid(), "_" ) : 'wf_'.$workflow->id.'_step_'.$posi ) : $code;
    }

    public static function createNewAsStartNode($titre, $description, $stylingClass, $workflow = null, $code = null, $validated_nextstep = null, $rejected_nextstep = null): WorkflowStep {
        $start_step = self::createNew($titre, $description, $stylingClass, $workflow, $code, $validated_nextstep, $rejected_nextstep)
            ->setAsStartNode(true)
            ->setFlowchartSize(config('Settings.flowchart.startnode.default_width'), config('Settings.flowchart.startnode.default_height'), true)
            ->setFlowchartPosition(config('Settings.flowchart.startnode.default_x'), config('Settings.flowchart.startnode.default_y'), true)
            ;
        $code = self::getCode($code, $workflow, -1);
        $start_step->update(['posi' => -1, 'code' => $code]);

        return $start_step;
    }

    public static function createNewAsEndNode($titre, $description, $stylingClass, $workflow = null, $code = null, $validated_nextstep = null, $rejected_nextstep = null): WorkflowStep {
        $end_step = self::createNew($titre, $description, $stylingClass, $workflow, $code, $validated_nextstep, $rejected_nextstep)
            ->setAsEndNode(true)
            ->setFlowchartSize(config('Settings.flowchart.endnode.default_width'), config('Settings.flowchart.endnode.default_height'), true)
            ->setFlowchartPosition(config('Settings.flowchart.endnode.default_x'), config('Settings.flowchart.endnode.default_y'), true)
            ;
        $code = self::getCode($code, $workflow, -2);
        $end_step->update(['posi' => -2, 'code' => $code]);

        return $end_step;
    }

    public static function createNewAsOperationNode($titre, $description, $stylingClass, $workflow = null, $code = null, $validated_nextstep = null, $rejected_nextstep = null): WorkflowStep {
        return self::createNew($titre, $description, $stylingClass, $workflow, $code, $validated_nextstep, $rejected_nextstep)
            ->setAsOperationNode(true);
    }

    public function addAction($action, $save = true) {
        if ( ! is_null($action) ) {

            $this->actions()->save($action);

            if ($save) {
                $this->save();
            }
        }
    }

    public function addValidationAction($titre, $description, $actiontype = null, $code = null) : WorkflowAction {
        return WorkflowAction::createValidationAction($titre, $description, $this, $actiontype, $code);
    }

    public function addRejectionAction($titre, $description, $actiontype = null, $code = null) : WorkflowAction {
        return WorkflowAction::createRejectionAction($titre, $description, $this, $actiontype, $code);
    }

    public function addRejectionEnumTypeAction($enum_name, array $enum_values, $titre, $description, $code = null) : WorkflowAction {
        return WorkflowAction::createRejectionEnumTypeAction($enum_name, $enum_values, $titre, $description, $this, $code);
    }

    public function addExpirationAction($titre, $description, $actiontype = null, $code = null) : WorkflowAction {
        return WorkflowAction::createExpirationAction($titre, $description, $this, $actiontype, $code);
    }

    public function addMotifRejet($required = false, $required_msg = "") : WorkflowAction {
        $string_type = WorkflowActionType::where('code', "STRING_value")->first();
        $action = $this->addRejectionAction("Motif Rejet", "Motif Rejet",$string_type);
        if ($required && $required_msg !== "") {
            $action->setRequired($required, $required_msg, true);
        }
        return $action;
    }

    public function addValidationFileAction($titre, $description, $code = null) : WorkflowAction {
        return WorkflowAction::createValidationFileAction($titre, $description, $this, $code);
    }

    /**
     * Paramètre les profile(s) de l'étape comme statique
     * @param $role_static
     * @param array|null $role_ids
     * @param bool $save
     * @return WorkflowStep
     */
    public function setApproversStatic($role_static, array $role_ids = null, $save = true) {
        if ($role_static && ( ! ( is_null($role_ids) || ( ! $role_ids ) || is_null($role_ids) || ( empty($role_ids) ) ) )) {
            // Configuration de profile statique
            $this->setApproversParameters($role_ids, false, "", "", false);

            if ($save) {
                $this->save();
            }
        }
        return $this;
    }

    /**
     * Paramètre le profile de l'étape comme dinamique
     * @param bool $role_dynamic
     * @param string $role_dynamic_label
     * @param $role_dynamic_previous_label
     * @param bool $save
     * @return WorkflowStep
     */
    public function setProfileDynamic($role_dynamic, $role_dynamic_label, $role_dynamic_previous_label, $save = true) {
        if ($role_dynamic) {
            // Configuration de profile dynamique
            $this->setApproversParameters(null, true, $role_dynamic_label, $role_dynamic_previous_label, false);

            if ($save) {
                $this->save();
            }
        }
        return $this;
    }

    /**
     * Paramètre le profile de l'étape comme identique à la précédente étape
     * @param bool $role_previous
     * @param bool $save
     * @return WorkflowStep
     */
    public function setProfilePrevious($role_previous, $save = true) {
        if ($role_previous) {
            // Configuration de profile précédent
            $this->setApproversParameters(null, false, "", "", true);

            if ($save) {
                $this->save();
            }
        }

        return $this;
    }

    /**
     * Modifie les paramètres de profile de l'acteur qui va exécuter l'action
     * @param array|null $role_ids
     * @param bool $role_dynamic
     * @param string $role_dynamic_label
     * @param $role_dynamic_previous_label
     * @param bool $role_previous
     */
    private function setApproversParameters($role_ids, $role_dynamic, $role_dynamic_label, $role_dynamic_previous_label, $role_previous) {

        if ( is_null($role_ids) || ( ! $role_ids ) || is_null($role_ids) || ( empty($role_ids) ) ) {
            $this->role_static = false;
            $this->staticapprovers()->detach();
        } else {
            $this->role_static = true;
            $this->staticapprovers()->sync($role_ids);
        }

        if ($role_dynamic) {
            $role_dynamic_previous_label = (is_null($role_dynamic_previous_label) || empty($role_dynamic_previous_label) || ( $role_dynamic_previous_label === "" ) ) ? "Profile précédent" : $role_dynamic_previous_label;
        }

        $this->role_dynamic = $role_dynamic;
        $this->role_dynamic_label = $role_dynamic_label;
        $this->role_dynamic_previous_label = $role_dynamic_previous_label;

        $this->role_previous = $role_previous;
    }

    /**
     * Configure l'expiration de l'étape
     * @param $can_expire
     * @param WorkflowStep $expired_nextstep
     * @param $source_position
     * @param $destination_position
     * @param integer $expire_hours
     * @param integer $expire_days
     * @param bool $save
     * @return WorkflowStep
     */
    public function setExpiration($can_expire, $expired_nextstep, $source_position, $destination_position, $expire_hours, $expire_days, $save = true) {
        if ($can_expire) {
            $this->can_expire = true;
            //$this->expired_nextstep_id = $expired_nextstep->id;
            $this->setNextStepAfterExpired($expired_nextstep, $source_position, $destination_position, true);
            $this->expire_hours = (int)$expire_hours;
            $this->expire_days = (int)$expire_days;
        } else {
            $this->unsetExpiration();
        }

        if ($save) { $this->save(); }

        return $this;
    }

    public function updateExpiration($can_expire, $expire_hours, $expire_days, $save = true) {
        if ($can_expire) {
            $this->can_expire = true;
            $this->expire_hours = (int)$expire_hours;
            $this->expire_days = (int)$expire_days;

            if ($save) { $this->save(); }
        }

        return $this;
    }

    /**
     * Désactive l'expiration de l'étape
     * @param bool $save
     * @return WorkflowStep
     */
    private function unsetExpiration($save = true) {
        $this->can_expire = false;
        //$this->transitionexpirestep()->disassociate();

        if ($save) { $this->save(); }

        return $this;
    }

    public function setPassTransition(WorkflowStep $destinantion, $source_position, $destination_position, $save = true) {

        WorkflowStepTransition::setPassTransition($this, $destinantion, $source_position, $destination_position, true);

        if ($save) { $this->save(); }

        return $this;
    }

    public function setRejectTransition(WorkflowStep $destinantion, $source_position, $destination_position, $save = true) {

        WorkflowStepTransition::setRejectTransition($this, $destinantion, $source_position, $destination_position, true);

        if ($save) { $this->save(); }

        return $this;
    }

    /**
     * Modifie l'étape suivante après validation
     * @param WorkflowStep $validated_nextstep
     * @param $source_position
     * @param $destination_position
     * @param bool $save
     * @return WorkflowStep
     */
    public function setNextStepAfterValidated(WorkflowStep $validated_nextstep, $source_position, $destination_position, $save = true) {

        WorkflowStepTransition::setPassTransition($this, $validated_nextstep, $source_position, $destination_position, true);

        if ($save) { $this->save(); }

        return $this;
    }

    /**
     * Modifie l'étape suivante après rejet de l'étape
     * @param WorkflowStep $rejected_nextstep
     * @param bool $save
     * @return WorkflowStep
     */
    public function setNextStepAfterRejected(WorkflowStep $rejected_nextstep, $source_position, $destination_position, $save = true) {

        WorkflowStepTransition::setRejectTransition($this, $rejected_nextstep, $source_position, $destination_position, true);

        if ($save) { $this->save(); }

        return $this;
    }

    public function setNextStepAfterExpired(WorkflowStep $expired_nextstep, $source_position, $destination_position, $save = true) {

        WorkflowStepTransition::setExpireTransition($this, $expired_nextstep, $source_position, $destination_position, true);

        if ($save) { $this->save(); }

        return $this;
    }

    public function setNextStepAllways(WorkflowStep $allways_nextstep, $source_position, $destination_position, $save = true) {

        WorkflowStepTransition::setAllwaysTransition($this, $allways_nextstep, $source_position, $destination_position, true);

        if ($save) { $this->save(); }

        return $this;
    }

    public function setNotifyToProfile($notify_to_approvers, $save = true) {
        if ( is_null($notify_to_approvers) || ( ! $notify_to_approvers ) ) {
            $this->notify_to_approvers = 0;
        } else {
            $this->notify_to_approvers = 1;
        }
        if ($save) { $this->save(); }

        return $this;
    }

    public function setNotifyToOthers($notify_to_others, $otherstonotify, $save = true) {
        if ( is_null($notify_to_others) || ( ! $notify_to_others ) || is_null($otherstonotify) || ( empty($otherstonotify) ) ) {
            $this->notify_to_others = 0;
            $this->otherstonotify()->detach();
        } else {
            $this->notify_to_others = 1;
            $this->otherstonotify()->sync($otherstonotify);
        }
        if ($save) { $this->save(); }

        return $this;
    }

    /**
     * Configure l étape  parente de cette étape
     * @param WorkflowStep $step_parent
     * @param bool $save
     * @return WorkflowStep
     */
    public function setStepParent(WorkflowStep $step_parent = null, $save = true) : WorkflowStep {
        if ( is_null($step_parent) ) {
            $this->stepparent()->disassociate();
        } else {
            $this->stepparent()->associate($step_parent);
        }

        if ($save) { $this->save(); }

        return $this;
    }

    /**
     * Configure le type d étape
     * @param WorkflowStepType|null $step_type
     * @param bool $save
     * @return $this
     */
    public function setStepType(WorkflowStepType $step_type = null, $save = true) : WorkflowStep {
        if ( is_null($step_type) ) {
            $this->type()->disassociate();
        } else {
            $this->type()->associate($step_type);
        }

        if ($save) { $this->save(); }

        return $this;
    }

    public function removeFromWorkflow() {
        $this->workflow()->dissociate();
        try {
            $this->delete();
        } catch (\Exception $e) {
        }
    }

    public function removeTransition(WorkflowStepTransition $transition) {
        $transition->removeFromSteps();
    }

    #region Flowchart

    public function setAsStartNode($save = true) : WorkflowStep {
        return $this->setStepType(WorkflowStepType::getStartType(), true);
    }

    public function setAsEndNode($save = true) : WorkflowStep {
        return $this->setStepType(WorkflowStepType::getEndType(), true);
    }

    public function setAsOperationNode($save = true) : WorkflowStep {
        return $this->setStepType(WorkflowStepType::getOperationType(), true);
    }

    public function setFlowchartPosition($x, $y, $save = true) : WorkflowStep {
        $this->flowchart_position_x = $x;
        $this->flowchart_position_y = $y;

        if ($save) { $this->save(); }

        return $this;
    }

    public function setFlowchartSize($width, $height, $save = true) : WorkflowStep {
        $this->flowchart_size_width = $width;
        $this->flowchart_size_height = $height;

        //dd('Settings.flowchart.endnode.default_width: ',config('Settings.flowchart.endnode.default_width'), 'Settings.flowchart.endnode.default_height: ', config('Settings.flowchart.endnode.default_height'));

        if ($save) { $this->save(); }

        return $this;
    }

    public function getTransitionsArray() : array {
        $arr_final = [];

        foreach ($this->transitions as $transition) {
            $allways_type = WorkflowTreatmentType::getAllwaysType();
            if ($transition->treatmenttype->code === $allways_type->code) {
                $arr_final[$transition->treatmenttype->code] = $transition->destination;
                foreach (WorkflowTreatmentType::all() as $type) {
                    $arr_final[$type->code] = $transition->destination;
                }
            } else {
                $arr_final[$transition->treatmenttype->code] = $transition->destination;
            }
        }

        return $arr_final;
    }

    #endregion

    #endregion

    #region Custom Functions - Exec

    /**
     * Demarre cette étape
     * @return WorkflowExecStep
     */
    public function launch(WorkflowExec $exec) : ?WorkflowExecStep {
        // si l étape est active
        if ($this->status->code == "active") {
            $unprocessable_status_ids = WorkflowStatus::whereIn('code', ['validated', 'rejected'])->get()->pluck('id')->toArray();
            $execstep = WorkflowExecStep::where('workflow_exec_id', $exec->id)
                ->where('workflow_step_id', $this->id)
                ->whereNotIn('workflow_status_id', $unprocessable_status_ids)
                ->first();
            if ($execstep) {
                return $execstep;
            } else {
                $execstep = WorkflowExecStep::create([
                    'workflow_exec_id' => $exec->id,
                    'workflow_step_id' => $this->id,
                    'posi' => WorkflowExecStep::where('workflow_exec_id', $exec->id)->count() + 1,
                    'report' => json_encode([]),
                ]);

                return $execstep;
            }
        } else {
            return null;
        }
    }

    /**
     * Détermine si l'étape est la dernière du workflow
     * @return bool
     */
    public function isLastStep() {
        $workflowsteptype_end = WorkflowStepType::getEndType();
        return ( $this->type->id === $workflowsteptype_end->id );
    }

    #endregion

    public static function boot(){
        parent::boot();

        static::saving(function ($model) {
            if ( $model->role_dynamic ) {
                if ( is_null($model->role_dynamic_label) || $model->role_dynamic_label === "" ) {
                    $model->role_dynamic_label = config('Settings.workflowstep.roledynamic.default_label');
                }
                if ( is_null($model->role_dynamic_previous_label) || $model->role_dynamic_previous_label === "" ) {
                    $model->role_dynamic_previous_label = config('Settings.workflowstep.roledynamic.default_previous_label');
                }
            }

            if ( $model->can_expire ) {
                if ( is_null($model->expire_hours) || $model->expire_hours === 0 ) {
                    $model->expire_hours = config('Settings.workflowstep.canexpire.default_hours');
                }
                if ( is_null($model->expire_days) || $model->expire_days === 0 ) {
                    $model->expire_days = config('Settings.workflowstep.canexpire.default_days');
                }
            }
        });
    }
}
