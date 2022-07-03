<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateModelAttributesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'model_attributes';
    public $table_comment = 'list of attributes of model types of the system';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->string('label');
            $table->string('type')->nullable();

            $table->foreignId('model_type_id')->nullable()
                ->comment('model type reference')
                ->constrained('model_types')->onDelete('set null');

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
            $table->dropForeign(['model_type_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
