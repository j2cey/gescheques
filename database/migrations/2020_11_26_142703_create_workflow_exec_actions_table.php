<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateWorkflowExecActionsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_exec_actions';
    public $table_comment = 'Instance des actions effectuées/a effectuer par le workflow';

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

            $table->foreignId('workflow_action_id')->nullable()
                ->comment('référence de l action')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_status_id')->nullable()
                ->comment('référence du statut')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_process_status_id')->nullable()
                ->comment('référence du statut d exécution du workflow')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_exec_step_id')->nullable()
                ->comment('référence de l instance d exécution de l etape de workflow')
                ->constrained()->onDelete('set null');

            $table->foreignId('user_id')->nullable()
                ->comment('référence de l utilisateur')
                ->constrained()->onDelete('set null');

            $table->string('username')->nullable()->comment('l utilisateur qui a exécuté l action');

            $table->integer('posi')->default(0)->comment('position de l action dans l étape d execution de workflow');

            $table->string('model_type')->nullable()->comment('type du modèle modifié');
            $table->integer('model_id')->nullable()->comment('id du modèle modifié');
            $table->string('field_name')->nullable()->comment('nom du champs');
            $table->string('old_value')->nullable()->comment('ancienne valeur');
            $table->string('new_value', 500)->nullable()->comment('nouvelle valeur');

            $table->string('save_result')->nullable()->comment('resultat de l enregistrement de la modif apportee a l objet');

            $table->bigInteger('BIGINT_value')->nullable()->comment('BIGINT equivalent column');
            $table->binary('BLOB_value')->nullable()->comment('BLOB equivalent column (binary)');
            $table->boolean('BOOLEAN_value')->nullable()->comment('BOOLEAN equivalent column');
            $table->char('CHAR_value')->nullable()->comment('CHAR equivalent column with of a given length');
            $table->dateTime('DATETIME_value')->nullable()->comment('DATETIME equivalent column with an optional precision (total digits)');
            $table->date('DATE_value')->nullable()->comment('DATE equivalent column');
            $table->decimal('DECIMAL_value', $precision = 8, $scale = 2)->nullable()->comment('DECIMAL equivalent column with the given precision (total digits) and scale (decimal digits)');
            $table->double('DOUBLE_value', 8, 2)->nullable()->comment('DOUBLE equivalent column with the given precision (total digits) and scale (decimal digits)');
            $table->float('FLOAT_value', 8, 2)->nullable()->comment('a FLOAT equivalent column with the given precision (total digits) and scale (decimal digits)');
            $table->integer('INTEGER_value')->nullable()->comment('an INTEGER equivalent column');
            $table->ipAddress('IPADDRESS_value')->nullable()->comment('a VARCHAR equivalent column');
            $table->string('STRING_value')->nullable()->comment('a VARCHAR equivalent column of the given length');
            $table->text('TEXT_value')->nullable()->comment('a TEXT equivalent column');
            $table->bigInteger('FILE_ref')->nullable()->comment('File reference');
            $table->json('EnumType_value')->nullable()->comment('EnumType value');

            $table->timestamp('start_at')->nullable()->comment('date de début d exécution de l action d étape de workflow');
            $table->timestamp('end_at')->nullable()->comment('date de fin d exécution de l action d étape de workflow');

            $table->json('report')->comment('rapport d exécution');
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
            $table->dropForeign(['user_id']);
            $table->dropForeign(['workflow_exec_step_id']);
            $table->dropForeign(['workflow_action_id']);
            $table->dropForeign(['workflow_status_id']);
            $table->dropForeign(['workflow_process_status_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
