<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReminderObjectsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'reminder_objects';
    public $table_comment = 'instance of object of the system applying a specific reminder';

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

            $table->foreignId('reminder_id')->nullable()
                ->comment('reminder reference')
                ->constrained('reminders')->onDelete('set null');

            $table->string('title')->nullable()->comment('title of reminder object');
            $table->unsignedBigInteger('model_id')->comment('model id reference');

            $table->timestamp('notification_start_at')->nullable()->comment('date notification start');
            $table->timestamp('notification_last_time')->nullable()->comment('last time notification has been done');
            $table->timestamp('notification_end_at')->nullable()->comment('date notification ends');

            $table->string('description')->nullable()->comment('reminder object description');
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
            $table->dropForeign(['reminder_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
