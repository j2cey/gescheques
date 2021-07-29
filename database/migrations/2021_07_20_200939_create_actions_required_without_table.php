<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateActionsRequiredWithoutTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'actions_required_without';
    public $table_comment = 'liste des actions dont la présence rend l action facultative.';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->foreignId('main_workflow_action_id')->nullable()
                ->comment('référence de l action principale')
                ->constrained('workflow_actions')->onDelete('set null');

            $table->foreignId('workflow_action_id')->nullable()
                ->comment('référence de l action')
                ->constrained('workflow_actions')->onDelete('set null');

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
            $table->dropForeign(['main_workflow_action_id']);
            $table->dropForeign(['workflow_action_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
