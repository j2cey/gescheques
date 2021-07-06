<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateBordereauremiseLignesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'bordereauremise_lignes';
    public $table_comment = 'lignes de bordereaux de remise';

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

            $table->foreignId('bordereauremise_id')->nullable()
                ->comment('référence du bordereau de remise')
                ->constrained('bordereauremises')->onDelete('set null');

            $table->string('classe_paiement')->nullable()->comment('classe de paiement de la ligne');
            $table->string('reference')->nullable()->comment('classe de paiement de la ligne');
            $table->integer('montant')->nullable()->comment('montant de la ligne');

            $table->foreignId('bordereauremise_etat_id')->nullable()
                ->comment('référence de l etat de la ligne bordereau')
                ->constrained('bordereauremise_etats')->onDelete('set null');

            // Champs à modifier par le workflow (Finance)
            $table->timestamp('date_valeur_finance')->nullable()->comment('date valeur');
            $table->integer('montant_depose_finance')->nullable()->comment('montant déposé (finance)');
            $table->string('commentaire_finance')->nullable()->comment('commentaire finance');
            $table->boolean('rejet_finances')->default(false)->comment('détermine si la ligne est rejétée par les finances');
            $table->string('motif_rejet_finances')->nullable()->comment('mùotif de rejet de la ligne par les finances');
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
            $table->dropForeign(['bordereauremise_id']);
            $table->dropForeign(['bordereauremise_etat_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
