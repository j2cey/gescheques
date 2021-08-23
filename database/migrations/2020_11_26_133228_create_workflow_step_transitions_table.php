<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateWorkflowStepTransitionsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_step_transitions';
    public $table_comment = 'liste des transitions (connections) entre deux étapes données.';

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

            $table->string('code')->unique()->comment('code de la transition');

            $table->foreignId('workflow_step_source_id')->nullable()
                ->comment('référence de l étape source (départ)')
                ->constrained('workflow_steps')->onDelete('cascade');

            $table->foreignId('workflow_step_destination_id')->nullable()
                ->comment('référence de l étape cible (destinataire)')
                ->constrained('workflow_steps')->onDelete('cascade');

            $table->foreignId('workflow_treatment_type_id')->nullable()
                ->comment('référence du type de traitement')
                ->constrained('workflow_treatment_types')->onDelete('set null');

            $table->string('flowchart_source_position')->nullable()->comment('position du noeud source sur la connection dans le diagramme');
            $table->string('flowchart_destination_position')->nullable()->comment('position du noeud destinataire sur la connection dans le diagramme');
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
            $table->dropForeign(['workflow_step_source_id']);
            $table->dropForeign(['workflow_step_destination_id']);
            $table->dropForeign(['workflow_treatment_type_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
