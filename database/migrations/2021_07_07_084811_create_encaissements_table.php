<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Traits\Migrations\BaseMigrationTrait;

class CreateEncaissementsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'encaissements';
    public $table_comment = 'liste des encaissement provenant d ARIS';

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

            $table->foreignId('agence_id')->nullable()
                ->comment('référence de l agence')
                ->constrained('agences')->onDelete('set null');

            $table->string('PaymentKey')->unique()->comment('PaymentKey');
            $table->string('ReceiptNum')->nullable()->comment('ReceiptNum');
            $table->string('Reference')->nullable()->comment('Reference');
            $table->string('PaymentID')->nullable()->comment('PaymentID');
            $table->timestamp('DatePaid')->nullable()->comment('DatePaid');
            $table->string('EmployeeCode')->nullable()->comment('EmployeeCode');
            $table->string('CustomerNo')->nullable()->comment('CustomerNo');
            $table->string('PaymentClass')->nullable()->comment('PaymentClass');
            $table->string('OSS360_PaymentClass')->nullable()->comment('OSS360_PaymentClass');
            $table->string('OSS360_PaymentType')->nullable()->comment('OSS360_PaymentType');
            $table->timestamp('HistoryDateTime')->nullable()->comment('HistoryDateTime');
            $table->string('PaymentValidationStatus')->nullable()->comment('PaymentValidationStatus');
            $table->string('TrackingNumber')->nullable()->comment('TrackingNumber');
            $table->integer('TrackingNumberAmmount')->nullable()->comment('TrackingNumberAmmount');
            $table->string('BankName')->nullable()->comment('BankName');
            $table->string('BankName_formatted')->nullable()->comment('BankName_formatted');
            $table->string('AccountNumber')->nullable()->comment('AccountNumber');
            $table->integer('Initial_TotalAmountPaid')->nullable()->comment('Initial_TotalAmountPaid');
            $table->integer('Final_TotalAmountPaid')->nullable()->comment('Final_TotalAmountPaid');
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
            $table->dropForeign(['agence_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
