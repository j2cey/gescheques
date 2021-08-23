<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateWorkflowExecStepEffectiveroleTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_exec_step_effectiverole';
    public $table_comment = 'liste des profiles d acteurs (effectifs/appliqués) pour une exécution d étape de workflow (WorkflowExecStep) donnée';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->foreignId('workflow_exec_step_id')->nullable()
                ->comment('référence de l exécution d étape de workflow')
                ->constrained()->onDelete('set null');

            $table->foreignId('role_id')->nullable()
                ->comment('référence du profile')
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
            $table->dropForeign(['workflow_exec_step_id']);
            $table->dropForeign(['role_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
