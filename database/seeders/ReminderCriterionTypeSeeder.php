<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ReminderCriterionType;

class ReminderCriterionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReminderCriterionType::createNew("Duration Greater Or Equal Hours", "Where Duration Of a relavant date field is Greater Or Equal than hours", 'duration_greater_or_equal_hours');
        ReminderCriterionType::createNew("Duration Greater Or Equal Mins", "Where Duration Of a relavant date field is Greater Or Equal than minutes", 'duration_greater_or_equal_mins');
        ReminderCriterionType::createNew("Field Equals Value", "Where field has a specified value", 'field_equals_value');
        ReminderCriterionType::createNew("Field Not Equals Value", "Where field has a value different to specified value", 'field_not_equals_value');
    }
}
