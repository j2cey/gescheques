<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateWorkflowstepOthersToNotifyTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflowstep_others_to_notify';
    public $table_comment = 'liste des utilisateurs (autre que profile) à notifier';

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

            $table->foreignId('user_id')->nullable()
                ->comment('référence du user')
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
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
