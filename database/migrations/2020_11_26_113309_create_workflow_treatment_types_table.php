<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateWorkflowTreatmentTypesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_treatment_types';
    public $table_comment = 'type de traitement de workflow.';

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

            $table->string('name')->comment('treatment type name');
            $table->string('code', 100)->unique()->comment('treatment type code');
            $table->string('description')->nullable()->comment('treatment type description');
            $table->string('stylingClass')->nullable()->comment('classe de style pour le diagramme');
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
