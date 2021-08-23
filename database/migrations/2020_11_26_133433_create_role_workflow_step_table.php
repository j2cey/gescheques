<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateRoleWorkflowStepTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'role_workflow_step';
    public $table_comment = 'liste des profiles d acteurs d une étape de workflow';

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
                ->comment('référence de l étape de workflow')
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
            $table->dropForeign(['workflow_step_id']);
            $table->dropForeign(['role_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
