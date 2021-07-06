<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateFieldsRequiredWithTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'fields_required_with';
    public $table_comment = 'liste des champs dont la présence rend le champs d action obligatoire.';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->foreignId('workflow_action_id')->nullable()
                ->comment('référence de l action')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_object_field_id')->nullable()
                ->comment('référence du champs d objet')
                ->constrained()->onDelete('set null');

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
            $table->dropForeign(['workflow_action_id']);
            $table->dropForeign(['workflow_object_field_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
