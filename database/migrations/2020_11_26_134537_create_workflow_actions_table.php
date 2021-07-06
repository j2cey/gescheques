<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateWorkflowActionsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_actions';
    public $table_comment = 'action de workflow';

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

            $table->string('titre')->comment('intitule de l action');
            $table->string('description')->nullable()->comment('description de l action');
            $table->string('model_type')->nullable()->comment('type du modèle lié');

            $table->foreignId('workflow_action_type_id')->nullable()
                ->comment('référence du type d action')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_step_id')->nullable()
                ->comment('référence de l étape de workflow parent')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_object_field_id')->nullable()
                ->comment('référence du champs d objet')
                ->constrained()->onDelete('set null');

            $table->boolean('field_required')->default(false)->comment('determine si le champs est requis');
            $table->string('field_required_msg')->nullable()->comment('message d erreur si le champs est requis');

            $table->boolean('field_required_without')->default(false)->comment('champ requis uniquement lorsque l un des autres champs spécifiés n est pas présent.');
            $table->string('field_required_without_msg')->nullable()->comment('message d erreur pour required_without');

            $table->boolean('field_required_with')->default(false)->comment('champ requis si l un des autres champs spécifiés est présent.');
            $table->string('field_required_with_msg')->nullable()->comment('message d erreur pour required_with');

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
            $table->dropForeign(['workflow_step_id']);
            $table->dropForeign(['workflow_action_type_id']);
            $table->dropForeign(['workflow_object_field_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
