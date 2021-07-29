<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StepCanExpire implements Rule
{
    private $can_expire;
    private $expire_hours;
    private $expire_days;

    /**
     * Create a new rule instance.
     *
     * @param $can_expire
     * @param $expire_hours
     * @param $expire_days
     */
    public function __construct($can_expire,$expire_hours,$expire_days)
    {
        $this->can_expire = $can_expire;
        $this->expire_hours = $expire_hours;
        $this->expire_days = $expire_days;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->can_expire) {
            if ($this->expire_hours === 0 && $this->expire_days === 0) {
                return $value > 0;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'heures ou jours requis.';
    }
}
