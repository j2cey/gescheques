<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReminderBroadlistsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'reminder_broadlists';
    public $table_comment = 'reminder broadcast list';

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

            $table->string('title')->comment('the broadcast list title');
            $table->string('broadlist_role')->nullable()->comment('the broadcast list role, if any');

            $table->string('msg')->nullable()->comment('the message');

            $table->integer('notification_interval')->default(8)->comment('interval between notifications');
            $table->timestamp('notification_start_at')->nullable()->comment('broadcast list notification start date');
            $table->timestamp('notification_last_time')->nullable()->comment('last time notification has been done');
            $table->timestamp('notification_end_at')->nullable()->comment('date notification ends');

            $table->string('description')->nullable()->comment('broadcast list description');
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
        });
        Schema::dropIfExists($this->table_name);
    }
}
