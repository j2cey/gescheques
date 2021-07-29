<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateFileMimeTypeTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'file_mime_type';
    public $table_comment = 'pivot table between files and mime_types';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            $table->foreignId('file_id')->nullable()
                ->comment('file reference')
                ->constrained()->onDelete('set null');

            $table->foreignId('mime_type_id')->nullable()
                ->comment('mime_type reference')
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
            $table->dropForeign(['file_id']);
            $table->dropForeign(['mime_type_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
