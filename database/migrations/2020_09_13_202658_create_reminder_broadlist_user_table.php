<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReminderBroadlistUserTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'reminder_broadlist_user';
    public $table_comment = 'a user to which a given reminder will send the notification';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->foreignId('broadlist_id')->nullable()
                ->comment('reminder broadcast list reference')
                ->constrained('reminder_broadlists')->onDelete('set null');

            $table->foreignId('user_id')->nullable()
                ->comment('user reference')
                ->constrained()->onDelete('set null');


            $table->string('custom_msg')->nullable()->comment('message to send to the user in case of no default message (set in the reminder object broadcast list)');
            $table->string('description')->nullable()->comment('relation description');

            $table->timestamps();
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
            $table->dropForeign(['broadlist_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
