<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateMimeTypeWorkflowActionTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'mime_type_workflow_action';
    public $table_comment = 'pivot table between mime_types and workflow_actions';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->foreignId('mime_type_id')->nullable()
                ->comment('mime_type reference')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_action_id')->nullable()
                ->comment('workflow_action reference')
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
            $table->dropForeign(['mime_type_id']);
            $table->dropForeign(['workflow_action_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
