<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateEnumTypesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'enum_types';
    public $table_comment = 'liste des types d énumération pouvant etre utilisées comme type de données d action de workflow.';

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

            $table->string('name')->unique()->comment('nom du type d énumération');
            $table->string('code')->unique()->comment('code du type d énumération');
            $table->string('description')->nullable()->comment('description du type d énumération');
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
