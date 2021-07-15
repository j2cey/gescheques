<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateFileImportResultsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'file_import_results';
    public $table_comment = 'résultat de l importation d un fichier donné';

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

            $table->boolean('imported')->default(false)->comment('determine si le fichier a deja ete importe dans la BD');
            $table->boolean('import_processing')->default(false)->comment('determine si le fichier est en cours de traitement');
            $table->timestamp('suspended_at')->nullable()->comment('date de suspension le cas échéant');

            $table->timestamp('importstart_at')->nullable()->comment('date de debut d importation dans la BD');
            $table->timestamp('importend_at')->nullable()->comment('date de fin d importation dans la BD');

            $table->integer('nb_rows')->default(0)->comment('nombre total de lignes');
            $table->integer('nb_rows_success')->default(0)->comment('nombre total de ligne(s) importée(s) avec succès');
            $table->integer('nb_rows_failed')->default(0)->comment('nombre total de ligne(s) echouée(s)');
            $table->integer('nb_rows_processing')->default(0)->comment('nombre total de ligne(s) en cours de traitement');
            $table->integer('nb_rows_processed')->default(0)->comment('nombre total de ligne(s) traitée(s)');

            $table->integer('row_last_processed')->default(0)->comment('derniere ligne traitée');
            $table->integer('nb_try')->default(0)->comment('nombre de tentative(s) de traitement');
            $table->json('report')->comment('rapport d importation');
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
