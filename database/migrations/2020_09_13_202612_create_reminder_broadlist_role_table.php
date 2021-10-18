<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReminderBroadlistRoleTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'reminder_broadlist_role';
    public $table_comment = 'a role to which a given reminder will send the notification';

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

            $table->foreignId('role_id')->nullable()
                ->comment('role reference')
                ->constrained()->onDelete('set null');

            $table->string('custom_msg')->nullable()->comment('message to send to the role in case of no default message (set in the reminder object boadcast list)');
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
            $table->dropForeign(['role_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
