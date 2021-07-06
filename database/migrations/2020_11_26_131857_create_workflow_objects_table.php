<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateWorkflowObjectsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_objects';
    public $table_comment = 'objet pouvant faire l objet d un workflow';

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

            $table->string('model_type')->comment('type du modele');
            $table->string('model_title')->comment('titre du modele');

            $table->foreignId('workflow_object_parent_id')->nullable()
                ->comment('reference de l objet parent')
                ->constrained('workflow_objects')->onDelete('set null');

            $table->string('ref_field')->nullable()->comment('champs référence');
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
