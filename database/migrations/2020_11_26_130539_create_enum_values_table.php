<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateEnumValuesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'enum_values';
    public $table_comment = 'liste des valeurs possibles pour un type d énumération donné';

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

            $table->foreignId('enum_type_id')->nullable()
                ->comment('référence du type d énumération')
                ->constrained()->onDelete('set null');

            $table->string('val')->unique()->comment('valeur');
            $table->string('description')->nullable()->comment('description de la valeur');
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
            $table->dropForeign(['enum_type_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
