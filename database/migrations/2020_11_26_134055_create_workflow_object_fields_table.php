<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateWorkflowObjectFieldsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_object_fields';
    public $table_comment = 'champs d objet pouvant faire l objet d un workflow';

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

            $table->string('db_field_name')->comment('nom du champs dans la base de données');
            $table->string('field_label')->comment('libele du champs');

            $table->foreignId('workflow_object_field_type_id')->nullable()
                ->comment('référence du type de champs')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_object_id')->nullable()
                ->comment('référence de l objet')
                ->constrained()->onDelete('set null');
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
            $table->dropForeign(['workflow_object_field_type_id']);
            $table->dropForeign(['workflow_object_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
