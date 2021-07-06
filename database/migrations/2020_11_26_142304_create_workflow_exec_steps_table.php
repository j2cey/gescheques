<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateWorkflowExecStepsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_exec_steps';
    public $table_comment = 'Instance d exécution d une étape de workflow';

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

            $table->foreignId('workflow_exec_id')->nullable()
                ->comment('référence de l instance d exécution de workflow')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_step_id')->nullable()
                ->comment('référence de l etape de workflow')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_status_id')->nullable()
                ->comment('référence du statut de workflow')
                ->constrained()->onDelete('set null');

            $table->foreignId('user_id')->nullable()
                ->comment('référence de l utilisateur')
                ->constrained()->onDelete('set null');

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
            $table->dropForeign(['workflow_step_id']);
            $table->dropForeign(['workflow_status_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
