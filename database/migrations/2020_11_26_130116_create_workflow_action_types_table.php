<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateWorkflowActionTypesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_action_types';
    public $table_comment = 'liste des types d action (type de données)';

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

            $table->string('name')->unique()->comment('nom du type d action');
            $table->string('code')->unique()->comment('code du type d action');
            $table->string('description')->nullable()->comment('description du type d action');
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
        });
        Schema::dropIfExists($this->table_name);
    }
}
