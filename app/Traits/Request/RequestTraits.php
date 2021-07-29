<?php

namespace App\Traits\Request;


use App\Models\User;
use App\Models\WorkflowStep;
use Spatie\Permission\Models\Role;
use App\Models\WorkflowActionType;

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
        if ($json_decode_before) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? Role::where('id', $value['id'])->first() : null;;
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
        if ($json_decode_before) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? User::where('id', $value['id'])->first() : null;
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
        if ($json_decode_before) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? WorkflowStep::where('id', $value['id'])->first() : null;;
    }

    public function setRelevantActionType($value, $json_decode_before = false) {
        if (is_null($value)) {
            return null;
        }
        if ($json_decode_before) {
            $value = $this->decodeJsonField($value);
        }
        return $value ? WorkflowActionType::where('id', $value['id'])->first() : null;;
    }
}
