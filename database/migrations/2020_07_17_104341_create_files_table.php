<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateFilesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'files';
    public $table_comment = 'files of the system.';

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

            $table->foreignId('current_mimetype_id')->nullable()
                ->comment('current mime type reference')
                ->constrained('mime_types')->onDelete('set null');

            $table->string('name')->comment('file name');
            $table->string('role')->comment('file role');
            $table->string('type')->nullable()->comment('file type');
            $table->integer('size')->nullable()->comment('file size');
            $table->string('extension')->nullable()->comment('file extension');
            $table->string('config_dir')->nullable()->comment('app config entry');
            $table->boolean('rawfiledeleted')->default(false)->comment('determine whether the raw (physical) file is deleted');

            $table->string('model_type')->nullable()->comment('type of referenced model');
            $table->bigInteger('model_id')->nullable()->comment('model reference');
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
            $table->dropForeign(['current_mimetype_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
