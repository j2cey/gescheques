<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateReminderCustomBroadlistTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'reminder_custom_broadlist';
    public $table_comment = 'custom broadcast list for a reminder object (directly attached)';

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

            $table->foreignId('reminder_object_id')->nullable()
                ->comment('reminder object reference')
                ->constrained('reminder_objects')->onDelete('set null');

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
            $table->dropForeign(['reminder_object_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
