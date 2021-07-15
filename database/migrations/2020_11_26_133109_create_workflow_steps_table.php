<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateWorkflowStepsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_steps';
    public $table_comment = 'liste des étapes d un workflow';

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

            $table->string('titre')->comment('titre de l étape');
            $table->integer('posi')->default(0)->comment('position de l étape dans le workflow');
            $table->string('description')->nullable()->comment('description de l étape');

            $table->foreignId('workflow_id')->nullable()
                ->comment('référence du workflow parent')
                ->constrained()->onDelete('set null');

            $table->foreignId('role_id')->nullable()
                ->comment('référence du profile de l acteur potentiel')
                ->constrained()->onDelete('set null');

            $table->foreignId('validated_nextstep_id')->nullable()
                ->comment('référence de la prochaine etape apres validation')
                ->constrained('workflow_steps')->onDelete('set null');

            $table->foreignId('rejected_nextstep_id')->nullable()
                ->comment('référence de la prochaine etape apres rejet')
                ->constrained('workflow_steps')->onDelete('set null');

            $table->string('code')->unique()->comment('code de l étape');
            $table->boolean('role_static')->default(false)->comment('détermine si le role de l étape doit être statique (donné au cours de l étape précédente)');
            $table->boolean('role_dynamic')->default(true)->comment('détermine si le role de l étape doit être dynamique (donné dans la description de l étape)');
            $table->string('role_dynamic_label')->nullable()->comment('libellé de role dynamique');
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
            $table->dropForeign(['role_id']);

            $table->dropForeign(['validated_nextstep_id']);
            $table->dropForeign(['rejected_nextstep_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
