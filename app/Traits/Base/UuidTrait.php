<?php

namespace App\Traits\Base;

use Illuminate\Support\Str;

trait UuidTrait
{
    public function generateUuid()
    {
        return Str::slug(Str::orderedUuid(), '_');
    }
}
