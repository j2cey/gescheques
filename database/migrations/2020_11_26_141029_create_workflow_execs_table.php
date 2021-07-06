<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateWorkflowExecsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_execs';
    public $table_comment = 'Instance d exécution d un workflow';

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

            $table->foreignId('workflow_id')->nullable()
                ->comment('référence du workflow')
                ->constrained()->onDelete('set null');

            $table->foreignId('current_step_id')->nullable()
                ->comment('référence de l etape courrante')
                ->constrained('workflow_steps')->onDelete('set null');

            $table->foreignId('workflow_status_id')->nullable()
                ->comment('référence du statut de workflow')
                ->constrained()->onDelete('set null');

            $table->boolean('traitement_effectif')->default(false)->comment('détermine si le traitement est traitée');

            $table->string('model_type')->comment('type du modèle référencé');
            $table->bigInteger('model_id')->comment('référence de l instance du modèle');
            $table->string('motif_rejet')->nullable()->comment('motif rejet le cas échéant');
            $table->json('report')->comment('rapport d exécution');

            $table->foreignId('current_step_role_id')->nullable()
                ->comment('référence du role de l etape courrante')
                ->constrained('roles')->onDelete('set null');
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
            $table->dropForeign(['workflow_id']);
            $table->dropForeign(['current_step_id']);
            $table->dropForeign(['workflow_status_id']);
            $table->dropForeign(['current_step_role_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
