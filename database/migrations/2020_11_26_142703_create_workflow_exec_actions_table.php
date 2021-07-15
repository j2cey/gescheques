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

            $table->foreignId('workflow_exec_step_id')->nullable()
                ->comment('référence de l instance d exécution de l etape de workflow')
                ->constrained()->onDelete('set null');

            $table->foreignId('user_id')->nullable()
                ->comment('référence de l utilisateur')
                ->constrained()->onDelete('set null');

            $table->string('username')->nullable()->comment('l utilisateur qui a exécuté l action');

            $table->integer('posi')->default(0)->comment('position de l action dans l étape d execution de workflow');

            $table->string('model_type')->nullable()->comment('type du modèle modifié');
            $table->integer('model_id')->nullable()->comment('id du modèle modifié');
            $table->string('field_name')->nullable()->comment('nom du champs');
            $table->string('old_value')->nullable()->comment('ancienne valeur');
            $table->string('new_value')->nullable()->comment('nouvelle valeur');

            $table->string('save_result')->nullable()->comment('resultat de l enregistrement de la modif apportee a l objet');

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
            $table->dropForeign(['user_id']);
            $table->dropForeign(['workflow_exec_step_id']);
            $table->dropForeign(['workflow_action_id']);
            $table->dropForeign(['workflow_status_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
