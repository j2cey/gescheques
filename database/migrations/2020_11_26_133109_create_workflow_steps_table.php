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

            // Champs principaux
            $table->string('titre')->comment('titre de l étape');
            $table->integer('posi')->default(0)->comment('position de l étape dans le workflow');
            $table->string('description')->nullable()->comment('description de l étape');

            $table->foreignId('workflow_id')->nullable()
                ->comment('référence du workflow parent')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_step_type_id')->nullable()
                ->comment('référence du type d étape')
                ->constrained()->onDelete('set null');

            // Etape parente (fait de l étape une sous-étape)
            $table->foreignId('step_parent_id')->nullable()
                ->comment('référence de l étape parente le cas échéant')
                ->constrained('workflow_steps')->onDelete('set null');

            $table->string('code')->unique()->comment('code de l étape');
            $table->boolean('role_static')->default(true)->comment('détermine si le role de l étape doit être statique (donné au cours de l étape précédente)');

            $table->boolean('role_dynamic')->default(false)->comment('détermine si le role de l étape doit être dynamique (donné dans la description de l étape)');
            $table->string('role_dynamic_label')->nullable()->comment('libellé de role dynamique');
            $table->string('role_dynamic_previous_label')->nullable()->comment('libellé de role précédent (cas de profile dynamique)');
            $table->boolean('role_previous')->default(false)->comment('détermine si le role de l étape doit être pris dans l étape précédente');

            // expiration de l étape
            $table->boolean('can_expire')->default(false)->comment('détermine si l étape peut expirer');
            $table->integer('expire_hours')->nullable()->comment('nombre d heure de validité de l étape');
            $table->integer('expire_days')->nullable()->comment('nombre de jours de validité de l étape');

            // Notification de l étape
            $table->boolean('notify_to_approvers')->default(false)->comment('notifier à tous les acteurs ayant le(s) profile(s) de l étape');
            $table->boolean('notify_to_others')->default(false)->comment('notifier à d autres personnes');

            // Prochaine étape après validation
            $table->boolean('validated_nextstep_dynamic')->default(false)->comment('détermine si la prochaine etape apres validation doit être dynamique');
            $table->boolean('validated_nextstep_static')->default(false)->comment('détermine si la prochaine etape apres validation doit être statique');

            // Prochaine étape après réjet
            $table->boolean('rejected_nextstep_dynamic')->default(false)->comment('détermine si la prochaine etape apres réjet doit être dynamique');
            $table->boolean('rejected_nextstep_static')->default(false)->comment('détermine si la prochaine etape apres réjet doit être statique');

            $table->string('stylingClass')->nullable()->comment('classe de style pour le diagramme');
            $table->integer('flowchart_position_x')->nullable()->comment('position x sur le diagramme');
            $table->integer('flowchart_position_y')->nullable()->comment('position y sur le diagramme');
            $table->integer('flowchart_size_width')->nullable()->comment('largeur du noeud sur le diagramme');
            $table->integer('flowchart_size_height')->nullable()->comment('hauteur du noeud sur le diagramme');
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
            $table->dropForeign(['workflow_step_type_id']);
            $table->dropForeign(['step_parent_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
