<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateBordereauremiseEtatsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'bordereauremise_etats';
    public $table_comment = 'Liste des Etats possible de bordereau et ligne de bordereau de remise.';

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

            $table->string('titre')->comment('titre de l etat');
            $table->string('code')->unique()->comment('code de l etat');
            $table->string('description')->nullable()->comment('description de l etat');
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
