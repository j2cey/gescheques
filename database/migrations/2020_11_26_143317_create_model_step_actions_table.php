<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateModelStepActionsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'model_step_actions';
    public $table_comment = 'liste des actions a exécuter par un model a une étape donnée';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->foreignId('workflow_exec_model_step_id')->nullable()
                ->comment('référence de l execution du modèle par étape')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_action_id')->nullable()
                ->comment('référence de l action')
                ->constrained()->onDelete('set null');

            $table->boolean('traitement_effectif')->default(false)->comment('détermine si l action a été traitée');
            $table->boolean('rejete')->default(false)->comment('détermine si l action a été rejétée');

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
            $table->dropForeign(['workflow_exec_model_step_id']);
            $table->dropForeign(['workflow_action_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
