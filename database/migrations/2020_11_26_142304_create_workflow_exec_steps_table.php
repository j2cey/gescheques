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

            $table->integer('posi')->default(0)->comment('position de l étape dans l execution de workflow');

            $table->foreignId('workflow_exec_id')->nullable()
                ->comment('référence de l instance d exécution de workflow')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_step_id')->nullable()
                ->comment('référence de l etape de workflow')
                ->constrained()->onDelete('set null');

            /*$table->foreignId('effective_role_id')->nullable()
                ->comment('référence de l etape de workflow')
                ->constrained('roles')->onDelete('set null');*/

            $table->foreignId('workflow_status_id')->nullable()
                ->comment('référence du statut de workflow')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_process_status_id')->nullable()
                ->comment('référence du statut d exécution du workflow')
                ->constrained()->onDelete('set null');

            $table->foreignId('user_id')->nullable()
                ->comment('référence de l utilisateur')
                ->constrained()->onDelete('set null');

            $table->string('username')->nullable()->comment('l utilisateur qui a exécuté l étape');

            $table->boolean('rejected')->default(false)->comment('détermine si l étape a été rejétée');
            $table->string('reject_comment')->nullable()->comment('commentaire de rejet le cas échéant');

            $table->boolean('expired')->default(false)->comment('détermine si l étape est expirée');
            $table->string('expire_comment')->nullable()->comment('commentaire d expiration le cas échéant');

            $table->timestamp('start_at')->nullable()->comment('date de début d exécution de l étape de workflow');
            $table->timestamp('end_at')->nullable()->comment('date de fin d exécution de l étape de workflow');

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
            //$table->dropForeign(['effective_role_id']);
            $table->dropForeign(['workflow_status_id']);
            $table->dropForeign(['workflow_process_status_id']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
