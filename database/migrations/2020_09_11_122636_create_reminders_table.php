<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateRemindersTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'reminders';
    public $table_comment = 'list of reminders of the system';

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

            $table->foreignId('model_type_id')->nullable()
                ->comment('model type reference')
                ->constrained()->onDelete('set null');

            $table->string('title')->comment('reminder title');
            $table->string('description')->nullable()->comment('reminder description');
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
            $table->dropForeign(['model_type_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
