<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class ModelHasWorkflow extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'model_has_workflow';
    public $table_comment = 'table de liaison entre un modèle et un workflow. Désigne le modèle déclancheur du workflow';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            //$table->baseFields();

            $table->foreignId('workflow_id')->nullable()
                ->comment('référence du workflow')
                ->constrained()->onDelete('set null');

            $table->string('model_type')->comment('type du modèle référencé');
            //$table->bigInteger('model_id')->comment('référence du modèle');
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
            //$table->dropBaseForeigns();
            $table->dropForeign(['workflow_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
