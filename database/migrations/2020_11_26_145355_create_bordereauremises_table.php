<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateBordereauremisesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'bordereauremises';
    public $table_comment = 'bordereaux de remise';

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

            $table->string('fichier_source')->nullable()->comment('fichier source du bordereau');
            $table->timestamp('date_remise')->nullable()->comment('date de remise');
            $table->string('numero_transaction')->nullable()->comment('numéro de transaction');
            $table->string('localisation')->nullable()->comment('localisation');
            $table->string('changement_dernier_tarif')->nullable()->comment('changement dernier tarif');

            $table->integer('montant_total')->nullable()->comment('montant total');
            // Champs à modifier par le workflow (Agence)
            $table->timestamp('date_depot_agence')->nullable()->comment('date de depot agence');
            $table->integer('montant_depose_agence')->nullable()->comment('montant déposé (agence)');
            $table->string('scan_bordereau')->nullable()->comment('fichier scan du bordereau');
            $table->string('commentaire_agence')->nullable()->comment('commentaire agence');

            $table->foreignId('bordereauremise_loc_id')->nullable()
                ->comment('référence de la localisation')
                ->constrained()->onDelete('set null');

            $table->foreignId('bordereauremise_modepaie_id')->nullable()
                ->comment('référence du mode de paiement')
                ->constrained()->onDelete('set null');

            $table->foreignId('bordereauremise_type_id')->nullable()
                ->comment('référence du type de bordereau')
                ->constrained('bordereauremise_types')->onDelete('set null');

            $table->foreignId('bordereauremise_etat_id')->nullable()
                ->comment('référence de l etat de bordereau')
                ->constrained('bordereauremise_etats')->onDelete('set null');

            //TODO: Retirer ces champs après normalisation
            $table->string('localisation_titre')->nullable()->comment('titre de la localisation');
            $table->string('modepaiement_titre')->nullable()->comment('titre du mode de paiement');
            $table->string('bordereauremise_type_titre')->nullable()->comment('titre du type de bordereau.');
            $table->string('bordereauremise_type_code')->nullable()->comment('code du type de bordereau.');
            $table->string('workflow_currentstep_titre')->nullable()->comment('titre de l étape de traitement actuelle, le cas échéant.');
            $table->string('workflow_currentstep_code')->nullable()->comment('code de l étape de traitement actuelle, le cas échéant.');
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
            $table->dropForeign(['bordereauremise_loc_id']);
            $table->dropForeign(['bordereauremise_modepaie_id']);
            $table->dropForeign(['bordereauremise_type_id']);
            $table->dropForeign(['bordereauremise_etat_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
