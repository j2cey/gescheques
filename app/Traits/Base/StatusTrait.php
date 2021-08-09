<?php

namespace App\Traits\Base;

use App\Models\Status;

trait StatusTrait
{
    public function setDefaultStatus() {
        if (empty($this->state_id)) {
            $default_status = Status::default();
            if ($default_status) {
                $this->status_id = $default_status->first()->id;
            }
        }
    }

    public function setStatus(Status $status = null, $save = true) {
        if ( is_null($status) ) {
            $this->status()->disassociate();
        } else {
            $this->status()->associate($status);
        }

        if ($save) { $this->save(); }

        return $this;
    }
}
