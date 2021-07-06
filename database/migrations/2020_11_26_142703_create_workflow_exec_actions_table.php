<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateWorkflowExecActionsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_exec_actions';
    public $table_comment = 'Instance des actions effectuées/a effectuer par le workflow';

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

            $table->foreignId('workflow_action_id')->nullable()
                ->comment('référence de l action')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_status_id')->nullable()
                ->comment('référence du statut')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_exec_id')->nullable()
                ->comment('référence de l instance d exécution de workflow')
                ->constrained()->onDelete('set null');

            $table->bigInteger('model_id')->nullable()->comment('référence de l instance du modèle');
            $table->string('model_type')->nullable()->comment('type de modèle (définit à la création)');

            $table->string('motif_rejet')->nullable()->comment('motif rejet le cas échéant');
            $table->json('report')->comment('rapport d exécution');
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
            $table->dropForeign(['workflow_exec_id']);
            $table->dropForeign(['workflow_action_id']);
            $table->dropForeign(['workflow_status_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
