<?php

namespace App\Traits\Request;

use App\Models\User;
use App\Models\Status;
use App\Models\EnumType;
use App\Models\Reminder;
use App\Models\ModelType;
use App\Models\WorkflowStep;
use App\Models\ModelAttribute;
use App\Models\ReminderBroadlist;
use Spatie\Permission\Models\Role;
use App\Models\WorkflowActionType;
use App\Models\WorkflowTreatmentType;
use App\Models\ReminderCriterionType;

trait RequestTraits
{
    /**
     * @param $value
     * @return mixed
     */
    public function decodeJsonField($value) {
        return json_decode($value, true);
    }

    public function setRelevantRole($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? Role::where('id', $value['id'])->first() : null;
    }

    public function setCheckOrOptionValue($value) {
        if (is_null($value) || $value === "null") {
            $value = null;
        }
        if ($value === "true") {
            $value = true;
        }
        if ($value === "false") {
            $value = false;
        }
        return intval($value);
    }

    public function setRelevantUser($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? User::where('id', $value['id'])->first() : null;
    }

    public function setRelevantStatus($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? Status::where('id', $value['id'])->first() : null;
    }

    public function setRelevantStatusByCode($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? Status::where('code', $value['code'])->first() : null;
    }

    public function setRelevantIdsList($value, $json_decode_before = false) {
        if (is_null($value) || empty($value)) {
            return null;
        }

        if ($json_decode_before) {
            $value = $this->decodeJsonField($value);
        }
        if (is_null($value) || empty($value)) {
            return null;
        }

        $ids = [];
        foreach ($value as $item) {
            $ids[] = $item['id'];
        }
        return $ids;
    }

    public function setRelevantStep($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? WorkflowStep::where('id', $value['id'])->first() : null;
    }

    public function setRelevantActionType($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? WorkflowActionType::where('id', $value['id'])->first() : null;
    }

    public function setRelevantEnumType($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? EnumType::where('id', $value['id'])->first() : null;
    }

    public function setRelevantTreatmentType($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? WorkflowTreatmentType::where('id', $value['id'])->first() : null;
    }

    public function setRelevantReminderCriterionType($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? ReminderCriterionType::where('id', $value['id'])->first() : null;
    }

    public function setEnumTypeFromId($value) {
        if (is_null($value)) {
            return null;
        }

        return $value ? EnumType::where('id', $value)->first() : null;
    }

    public function setReminderFromId($value) {
        if (is_null($value)) {
            return null;
        }

        return $value ? Reminder::where('id', $value)->first() : null;
    }

    public function setRelevantReminder($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? Reminder::where('id', $value['id'])->first() : null;
    }

    public function setRelevantReminderBroadlists($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }

        return $value ? ReminderBroadlist::whereIn('id', $this->setRelevantIdsList($value, $json_decode_before))->get() : null;
    }

    public function setRelevantModelType($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }

        return $value ? ModelType::where('id', $value['id'])->first() : null;
    }

    public function setRelevantModelAttribute($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before || is_string($value)) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? ModelAttribute::where('id', $value['id'])->first() : null;
    }
}
