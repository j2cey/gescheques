<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateEncaissementsFilesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'encaissements_files';
    public $table_comment = 'liste des fichiers d encaissements';

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

            $table->string('fichier')->nullable()->comment('file name');
            $table->integer('fichier_size')->nullable()->comment('file size');
            $table->string('fichier_type')->nullable()->comment('file type');

            $table->foreignId('file_import_result_id')->nullable()
                ->comment('référence du résultat d importation')
                ->constrained('file_import_results')->onDelete('set null');
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
            $table->dropForeign(['file_import_result_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
