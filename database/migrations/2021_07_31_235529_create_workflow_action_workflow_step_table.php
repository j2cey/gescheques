<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateWorkflowActionWorkflowStepTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_action_workflow_step';
    public $table_comment = 'liste des actions d une étape par type de traitement.';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->foreignId('workflow_step_id')->nullable()
                ->comment('référence de l étape')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_action_id')->nullable()
                ->comment('référence de l action')
                ->constrained()->onDelete('set null');

            $table->string('treatment_type')->comment('type de traitement [validation; rejection; expiration]');

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
            $table->dropForeign(['workflow_step_id']);
            $table->dropForeign(['workflow_action_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
