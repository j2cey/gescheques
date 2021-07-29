<?php

namespace App\Traits\Base;


use Illuminate\Support\Carbon;

trait BaseTrait
{
    use Uuidable, StatusTrait;

    public static function bootBaseTrait()
    {
        static::saving(function ($model) {
            if (is_null($model->status_id)) {
                $model->setDefaultStatus();
            }
        });
    }

    public function setStartAt($save = true) {
        $this->start_at = Carbon::now();
        if ($save) {
            $this->save();
        }

        return $this;
    }

    public function setEndAt($save = true) {
        $this->end_at = Carbon::now();
        if ($save) {
            $this->save();
        }

        return $this;
    }
}
