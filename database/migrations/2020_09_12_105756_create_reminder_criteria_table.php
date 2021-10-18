<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReminderCriteriaTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'reminder_criteria';
    public $table_comment = 'reminder criteria of the system';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->baseFields();

            $table->foreignId('reminder_criterion_type_id')->nullable()
                ->comment('criterion type reference')
                ->constrained('reminder_criterion_types')->onDelete('set null');

            $table->foreignId('model_attribute_id')->nullable()
                ->comment('model attribute reference')
                ->constrained('model_attributes')->onDelete('set null');

            $table->foreignId('reminder_id')->nullable()
                ->comment('reminder reference')
                ->constrained('reminders')->onDelete('set null');

            $table->string('title')->comment('criterion title');

            $table->boolean('is_start_criterion')->default(true)->comment('determine whether it s a criterion to start the reminder (the reverse will be used in case of no stop criterion)');
            $table->boolean('is_stop_criterion')->default(false)->comment('determine whether it s a criterion to stop the reminder');

            $table->string('criterion_value')->comment('criterion value');
            $table->string('criterion_role')->nullable()->comment('criterion role');
            $table->string('description')->nullable()->comment('criterion description');
        });
        $this->setTableComment($this->table_name,$this->table_comment);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropBaseForeigns();
            $table->dropForeign(['reminder_criterion_type_id']);
            $table->dropForeign(['reminder_id']);
            $table->dropForeign(['model_attribute_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
