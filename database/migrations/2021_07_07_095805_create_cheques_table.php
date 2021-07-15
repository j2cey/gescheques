<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateChequesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'cheques';
    public $table_comment = 'liste des cheques';

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

            $table->string('NREC_BANK_MVT_ID')->nullable()->comment('NREC_BANK_MVT_ID');
            $table->string('ACC_CODE')->nullable()->comment('ACC_CODE');
            $table->string('BANK_FLOW_CODE')->nullable()->comment('BANK_FLOW_CODE');
            $table->string('ABK_CUR_AMOUNT')->nullable()->comment('ABK_CUR_AMOUNT');
            $table->string('ABK_CUR_CODE')->nullable()->comment('ABK_CUR_CODE');
            $table->string('TRN_FLAG', 10)->nullable()->comment('TRN_FLAG');
            $table->string('TRN_AMOUNT')->nullable()->comment('TRN_AMOUNT');
            $table->string('TRN_CUR')->nullable()->comment('TRN_CUR');
            $table->string('CHEQUE_NB')->nullable()->comment('CHEQUE_NB');
            $table->string('BOOK_DATE')->nullable()->comment('BOOK_DATE');
            $table->string('VALUE_DATE')->nullable()->comment('VALUE_DATE');
            $table->string('DESCRIPTION')->nullable()->comment('DESCRIPTION');
            $table->string('COMPLEMENTS1')->nullable()->comment('COMPLEMENTS1');
            $table->string('COMPLEMENTS2')->nullable()->comment('COMPLEMENTS2');
            $table->string('COMPLEMENTS3')->nullable()->comment('COMPLEMENTS3');
            $table->string('COMPLEMENTS4')->nullable()->comment('COMPLEMENTS4');
            $table->string('COMPLEMENTS5')->nullable()->comment('COMPLEMENTS5');
            $table->string('COMPLEMENTS6')->nullable()->comment('COMPLEMENTS6');
            $table->string('COMPLEMENTS7')->nullable()->comment('COMPLEMENTS7');
            $table->string('COMPLEMENTS8')->nullable()->comment('COMPLEMENTS8');
            $table->string('COMPLEMENTS9')->nullable()->comment('COMPLEMENTS9');
            $table->string('COMPLEMENTS10')->nullable()->comment('COMPLEMENTS10');
            $table->string('COMPLEMENTS11')->nullable()->comment('COMPLEMENTS11');
            $table->string('COMPLEMENTS12')->nullable()->comment('COMPLEMENTS12');
            $table->string('COMPLEMENTS13')->nullable()->comment('COMPLEMENTS13');
            $table->string('COMPLEMENTS14')->nullable()->comment('COMPLEMENTS14');
            $table->string('COMPLEMENTS15')->nullable()->comment('COMPLEMENTS15');
            $table->string('COMPLEMENTS16')->nullable()->comment('COMPLEMENTS16');
            $table->string('COMPLEMENTS17')->nullable()->comment('COMPLEMENTS17');
            $table->string('COMPLEMENTS18')->nullable()->comment('COMPLEMENTS18');
            $table->string('COMPLEMENTS19')->nullable()->comment('COMPLEMENTS19');
            $table->string('COMPLEMENTS20')->nullable()->comment('COMPLEMENTS20');
            $table->string('COMPLEMENTS21')->nullable()->comment('COMPLEMENTS21');
            $table->string('COMPLEMENTS22')->nullable()->comment('COMPLEMENTS22');
            $table->string('COMPLEMENTS23')->nullable()->comment('COMPLEMENTS23');
            $table->string('COMPLEMENTS24')->nullable()->comment('COMPLEMENTS24');
            $table->string('SENSE_FLAG', 10)->nullable()->comment('SENSE_FLAG');
            $table->string('EURO_GAP_FLAG')->nullable()->comment('EURO_GAP_FLAG');
            $table->string('BANK_CUR_AMOUNT')->nullable()->comment('BANK_CUR_AMOUNT');
            $table->string('BANK_CUR_CODE')->nullable()->comment('BANK_CUR_CODE');
            $table->string('INTERNAL_MVT_ID')->nullable()->comment('INTERNAL_MVT_ID');
            $table->string('IMPORT_PROCESS_LOG_ID')->nullable()->comment('IMPORT_PROCESS_LOG_ID');
            $table->string('IMPORT_DATE')->nullable()->comment('IMPORT_DATE');
            $table->string('HISTORY_ID')->nullable()->comment('HISTORY_ID');
            $table->string('CALCULATION_METHOD')->nullable()->comment('CALCULATION_METHOD');
            $table->string('EXEMPT_FLAG', 10)->nullable()->comment('EXEMPT_FLAG');
            $table->string('EXTRACT_FLAG', 10)->nullable()->comment('EXTRACT_FLAG');
            $table->string('PRE_REC_ID')->nullable()->comment('PRE_REC_ID');
            $table->string('UNREC_DATE')->nullable()->comment('UNREC_DATE');
            $table->string('REC_TEMP_FLAG', 10)->nullable()->comment('REC_TEMP_FLAG');
            $table->string('NOT_DIRTY_FLAG', 10)->nullable()->comment('NOT_DIRTY_FLAG');
            $table->string('ZU_01', 30)->nullable()->comment('ZU_01');
            $table->string('ZU_02', 30)->nullable()->comment('ZU_02');
            $table->string('ZU_03', 30)->nullable()->comment('ZU_03');
            $table->string('ZU_04', 30)->nullable()->comment('ZU_04');
            $table->string('ZU_05', 30)->nullable()->comment('ZU_05');
            $table->string('ZU_06', 30)->nullable()->comment('ZU_06');
            $table->string('ZU_07', 30)->nullable()->comment('ZU_07');
            $table->string('ZU_08', 30)->nullable()->comment('ZU_08');
            $table->string('ZU_09', 30)->nullable()->comment('ZU_09');
            $table->string('ZU_10', 30)->nullable()->comment('ZU_10');
            $table->string('ROWVERSION')->nullable()->comment('ROWVERSION');
            $table->string('BankName_formatted')->nullable()->comment('BankName_formatted');

            $table->timestamp('date_traitement_finance')->nullable()->comment('date de traitrement DFIN');
            $table->string('scan_cheque')->nullable()->comment('scan cheque');
            $table->string('commentaire_finance')->nullable()->comment('commentaire finance');

            $table->timestamp('date_traitement_agence')->nullable()->comment('date de traitrement Agence');
            $table->string('commentaire_agence')->nullable()->comment('commentaire agence');

            $table->timestamp('date_traitement_dfr')->nullable()->comment('date de traitrement DFR');
            $table->string('commentaire_dfr')->nullable()->comment('commentaire dfr');

            $table->foreignId('bordereau_id')->nullable()
                ->comment('référence du bordereau')
                ->constrained('bordereaux')->onDelete('set null');

            $table->foreignId('encaissement_id')->nullable()
                ->comment('référence de l encaissement')
                ->constrained('encaissements')->onDelete('set null');
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
            $table->dropForeign(['bordereau_id']);
            $table->dropForeign(['encaissement_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
