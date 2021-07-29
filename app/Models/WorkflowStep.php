<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Rules\StepCanExpire;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
 * @property integer|null $role_id
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
 * @property boolean $notify_to_profile
 * @property boolean $notify_to_others
 *
 * @property integer|null $step_parent_id
 * @property integer|null $validated_nextstep_id
 * @property integer|null $rejected_nextstep_id
 * @property integer|null $expired_nextstep_id
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class WorkflowStep extends BaseModel implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $guarded = [];

    #region Eloquent Relationships

    public function workflow() {
        return $this->belongsTo(Workflow::class);
    }

    public function stepparent() {
        return $this->belongsTo(WorkflowStep::class, 'step_parent_id');
    }

    public function profile() {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function actions() {
        return $this->hasMany(WorkflowAction::class, 'workflow_step_id');
    }

    public function validatednextstep() {
        return $this->belongsTo(WorkflowStep::class, 'validated_nextstep_id');
    }

    public function rejectednextstep() {
        return $this->belongsTo(WorkflowStep::class, 'rejected_nextstep_id');
    }

    public function expirednextstep() {
        return $this->belongsTo(WorkflowStep::class, 'expired_nextstep_id');
    }

    public function otherstonotify() {
        return $this->belongsToMany(User::class, 'workflowstep_others_to_notify', 'workflow_step_id', 'user_id')
            ->withTimestamps();
    }

    #endregion

    #region Validation Rules

    public static function defaultRules($can_expire,$expire_hours,$expire_days) {
        return [
            'titre' => 'required',
            'profile' => 'required_unless:role_static,0',
            'validatednextstep' => 'required',
            'rejectednextstep' => 'required',
            'role_dynamic_label' => 'required_unless:role_dynamic,0',
            'role_dynamic_previous_label' => 'required_unless:role_dynamic,0',
            'expire_hours' => [ new StepCanExpire($can_expire,$expire_hours,$expire_days) ],
            'expire_days' => [ new StepCanExpire($can_expire,$expire_hours,$expire_days) ],
            'expirednextstep' => 'required_unless:can_expire,0',
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
    public static function messagesRules() {
        return [
            'titre.required' => 'Prière de Renseigner le Titre',
            'validatednextstep.required' => 'Une étape après validation est requise',
            'rejectednextstep.required' => 'Une étape après réjet est requise',
            'profile.required_unless' => 'Sélectionnez un profile (fixe)',
            'role_dynamic_label.required_unless' => 'Renseignez un libellé pour le profile dynamique',
            'role_dynamic_previous_label.required_unless' => 'Renseignez un libellé pour le profile précédent',
            'expirednextstep.required_unless' => 'Selectionnez l étape à suivre après expiration',
            'otherstonotify.required_unless' => 'Selectionnez le(les) utilisateur(s) à notifier',
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

    #region Custom Functions

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
    public static function createNew($titre, $description, $workflow = null, $code = null, $validated_nextstep = null, $rejected_nextstep = null): WorkflowStep {
        $posi = is_null($workflow) ? 0 : WorkflowStep::where('workflow_id', $workflow->id)->count('id');
        $code = is_null($code) ? ( is_null($workflow) ? Str::slug( (string)Str::orderedUuid(), "_" ) : 'wf_'.$workflow->id.'_step_'.$posi ) : $code;
        $step = WorkflowStep::create([
            'titre' => $titre,
            'code' => $code,
            'description' => $description,
            'posi' => $posi,
        ]);

        if( ! is_null($validated_nextstep) ) $step->setNextStepAfterValidated($validated_nextstep, false);
        if( ! is_null($rejected_nextstep) ) $step->setNextStepAfterRejected($rejected_nextstep, false);

        if( ! is_null($workflow) ) $step->workflow_id = $workflow->id;
        if( ! is_null($validated_nextstep) ) $step->validated_nextstep_id = $validated_nextstep->id;
        if( ! is_null($rejected_nextstep) ) $step->rejected_nextstep_id = $rejected_nextstep->id;

        $step->save();

        return $step;
    }

    /**
     * Paramètre le profile de l'étape comme statique
     * @param $role_static
     * @param Role|null $role
     * @param bool $save
     * @return WorkflowStep
     */
    public function setProfileStatic($role_static, Role $role = null, $save = true) {
        if ($role_static && ( ! is_null($role) )) {
            // Configuration de profile statique
            $this->setProfileParameters($role, false, "", "", false);

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
            $this->setProfileParameters(null, true, $role_dynamic_label, $role_dynamic_previous_label, false);

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
            $this->setProfileParameters(null, false, "", "", true);

            if ($save) {
                $this->save();
            }
        }

        return $this;
    }

    /**
     * Modifie les paramètres de profile de l'acteur qui va exécuter l'action
     * @param Role|null $role
     * @param bool $role_dynamic
     * @param string $role_dynamic_label
     * @param $role_dynamic_previous_label
     * @param bool $role_previous
     */
    private function setProfileParameters($role, $role_dynamic, $role_dynamic_label, $role_dynamic_previous_label, $role_previous) {
        $this->role_static = ( is_null($role) ? false : true );
        if ( is_null($role) ) {
            //$this->role_id = null;
            $this->profile()->dissociate();
        } else {
            //$this->role_id = $role_id;
            $this->profile()->associate($role);
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
     * @param integer $expire_hours
     * @param integer $expire_days
     * @param bool $save
     * @return WorkflowStep
     */
    public function setExpiration($can_expire, $expired_nextstep, $expire_hours, $expire_days, $save = true) {
        if ($can_expire) {
            $this->can_expire = true;
            //$this->expired_nextstep_id = $expired_nextstep->id;
            $this->expirednextstep()->associate($expired_nextstep);
            $this->expire_hours = (int)$expire_hours;
            $this->expire_days = (int)$expire_days;
        } else {
            $this->unsetExpiration();
        }

        if ($save) { $this->save(); }

        return $this;
    }

    /**
     * Désactive l'expiration de l'étape
     * @param bool $save
     * @return WorkflowStep
     */
    private function unsetExpiration($save = true) {
        $this->can_expire = false;
        $this->expirednextstep()->disassociate();

        if ($save) { $this->save(); }

        return $this;
    }

    /**
     * Modifie l'étape suivante après validation
     * @param WorkflowStep $validated_nextstep
     * @param bool $save
     * @return WorkflowStep
     */
    public function setNextStepAfterValidated(WorkflowStep $validated_nextstep, $save = true) {

        //$this->validated_nextstep_id = $validated_nextstep->id;
        $this->validatednextstep()->associate($validated_nextstep);

        if ($save) { $this->save(); }

        return $this;
    }

    /**
     * Modifie l'étape suivante après rejet de l'étape
     * @param WorkflowStep $rejected_nextstep
     * @param bool $save
     * @return WorkflowStep
     */
    public function setNextStepAfterRejected(WorkflowStep $rejected_nextstep, $save = true) {

        //$this->rejected_nextstep_id = $rejected_nextstep->id;
        $this->rejectednextstep()->associate($rejected_nextstep);

        if ($save) { $this->save(); }

        return $this;
    }

    public function setNotifyToProfile($notify_to_profile, $save = true) {
        if ( is_null($notify_to_profile) || ( ! $notify_to_profile ) ) {
            $this->notify_to_profile = 0;
        } else {
            $this->notify_to_profile = 1;
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
    public function setSetpParent(WorkflowStep $step_parent = null, $save = true) {
        if ( is_null($step_parent) ) {
            $this->stepparent()->disassociate();
        } else {
            $this->stepparent()->associate($step_parent);
        }

        if ($save) { $this->save(); }

        return $this;
    }

    public function isLastStep() {
        return $this->code === "step_end";
    }

    #endregion

    #region Custom Functions - Exec

    /**
     * Demarre cette étape
     * @return WorkflowExecStep
     */
    public function launch($exec) : ?WorkflowExecStep {
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

    #endregion

    public static function boot(){
        parent::boot();

    }
}
