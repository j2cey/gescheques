<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class WorkflowStepTransition
 * @package App\Models
 *
 * @property integer|null $workflow_step_source_id
 * @property integer|null $workflow_step_destination_id
 * @property integer|null $workflow_treatment_type_id
 *
 * @property string|null $flowchart_source_position
 * @property string|null $flowchart_destination_position
 *
 * @property string $code
 * @property WorkflowTreatmentType $treatmenttype
 * @property WorkflowStep $source
 * @property WorkflowStep $destination
 */
class WorkflowStepTransition extends BaseModel
{
    use HasFactory;

    protected $with = ['treatmenttype','destination'];

    #region Eloquent Relationships

    public function source() {
        return $this->belongsTo(WorkflowStep::class, 'workflow_step_source_id');
    }

    public function destination() {
        return $this->belongsTo(WorkflowStep::class, 'workflow_step_destination_id');
    }

    public function treatmenttype() {
        return $this->belongsTo(WorkflowTreatmentType::class, 'workflow_treatment_type_id');
    }

    #endregion

    #region Custom Functions

    public static function setSource(WorkflowStep $source, WorkflowTreatmentType $treatment_type, $source_position, $save = false) : WorkflowStepTransition {
        $transition = WorkflowStepTransition::where('workflow_step_source_id', $source->id)
            ->where('workflow_treatment_type_id', $treatment_type->id)
            ->first();

        if (! $transition) {
            $transition = new WorkflowStepTransition();
            $transition->code = 'wfstep_trans_' . Str::slug( (string)Str::orderedUuid(), "_" );
            $transition->save();
            $transition->source()->associate($source)->save();
            $transition->treatmenttype()->associate($treatment_type)->save();
        }

        $transition->flowchart_source_position = $source_position;

        if ($save) {
            $transition->save();
        }

        return $transition;
    }

    public function setDestination(WorkflowStep $step, $destination_position, $save = false) : WorkflowStepTransition {
        if ($step) {

            $this->destination()->associate($step);
            $this->flowchart_destination_position = $destination_position;

            if ($save) {
                $this->save();
            }
        }

        return $this;
    }

    public static function setPassTransition(WorkflowStep $source, WorkflowStep $destination, $source_position, $destination_position, $save = true) : WorkflowStepTransition {
        $transition = self::setSource($source, WorkflowTreatmentType::getPassType(), $source_position);
        $transition->setDestination($destination, $destination_position);

        if ($save) {
            $transition->save();
        }

        return $transition;
    }

    public static function setRejectTransition(WorkflowStep $source, WorkflowStep $destination, $source_position, $destination_position, $save = true) : WorkflowStepTransition {
        $transition = self::setSource($source, WorkflowTreatmentType::getRejectType(), $source_position);
        $transition->setDestination($destination, $destination_position);

        if ($save) {
            $transition->save();
        }

        return $transition;
    }

    // TODO: Manage expire transition
    public static function setExpireTransition(WorkflowStep $source, WorkflowStep $destination, $source_position, $destination_position, $save = true) : WorkflowStepTransition {
        $transition = self::setSource($source, WorkflowTreatmentType::getExpireType(), $source_position);
        $transition->setDestination($destination, $destination_position);

        if ($save) {
            $transition->save();
        }

        return $transition;
    }

    // TODO: Manage allways transition
    public static function setAllwaysTransition(WorkflowStep $source, WorkflowStep $destination, $source_position, $destination_position, $save = true) : WorkflowStepTransition {
        $transition = self::setSource($source, WorkflowTreatmentType::getAllwaysType(), $source_position);
        $transition->setDestination($destination, $destination_position);

        if ($save) {
            $transition->save();
        }

        return $transition;
    }

    public static function setOne(WorkflowTreatmentType $workflowtreatmenttype ,WorkflowStep $source, WorkflowStep $destination, $source_position, $destination_position, $save = true) : WorkflowStepTransition {
        $transition = self::setSource($source, $workflowtreatmenttype, $source_position);
        $transition->setDestination($destination, $destination_position);

        if ($save) {
            $transition->save();
        }

        return $transition;
    }

    public function removeFromSteps() {
        $this->source()->dissociate();
        $this->destination()->dissociate();
        $this->treatmenttype()->dissociate();
        try {
            $this->delete();
        } catch (\Exception $e) {
        }
    }

    #endregion
}
