<?php

namespace App\Traits\Workflow;


trait ExecTrait
{
    public function getLastModelId($model_type){
        return $model_type::orderBy('id', 'DESC')->first()->id;
    }
}
