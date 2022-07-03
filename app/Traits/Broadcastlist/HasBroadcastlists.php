<?php


namespace App\Traits\Broadcastlist;

use App\Models\ReminderBroadlist;

trait HasBroadcastlists
{
    abstract public function broadcastlists();

    public function syncBroadlists($broadcastlists) {

        if (is_null($broadcastlists) || ( !$broadcastlists )) {
            return $this;
        }

        $this->broadcastlists()->sync($broadcastlists);

        return $this;
    }

    public function addBroadlist($broadcastlistId) {

        if (is_null($broadcastlistId) || ( !$broadcastlistId )) {
            return $this;
        }

        $this->broadcastlists()->attach($broadcastlistId);

        return $this;
    }
}
