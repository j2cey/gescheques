<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Agence;
use App\Models\Encaissement;
use Illuminate\Validation\Rule;
use App\Models\FileImportResult;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;

class EncaissementsCsvImport implements ToModel, WithChunkReading, WithEvents, WithValidation, SkipsOnError
{
    use RemembersRowNumber, Importable, SkipsFailures, SkipsErrors;

    private $rownum = 0;
    private $totalRows = 0;
    private FileImportResult $import_result;

    public function __construct(FileImportResult $import_result)
    {
        $this->import_result = $import_result;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $currentRowNumber = $this->getRowNumber();

        if ($currentRowNumber == 1) {
            $this->nextRow();
            $this->registerEvents();
            $this->import_result->update(['nb_rows' => $this->totalRows]);
            return null;
        }

        if ($currentRowNumber < $this->import_result->row_last_processed) {
            $this->nextRow();
            return null;
        }

        // Skip Duplicates
        if( Encaissement::where('PaymentKey', $row[0])->count() > 0 ) {
            return null;
        }

        $agence = Agence::where('Location', $row[7])->first();
        if( ! $agence ) {
            $agence = Agence::Create([
                'Location' => $row[7],
                'LocationName' => $row[8],
            ]);
        }

        $new_encaissement = new Encaissement([
            'PaymentKey' => $row[0],
            'ReceiptNum' => $row[1],
            'Reference' => $row[2],
            'PaymentID' => $row[3],
            'DatePaid' => Carbon::createFromFormat('d/m/Y', $row[4])->format('Y-m-d'),//Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4])),
            'EmployeeCode' => $row[5],
            'CustomerNo' => $row[6],
            'agence_id' => $agence->id,
            'PaymentClass' => $row[9],
            'OSS360_PaymentClass' => $row[10],
            'OSS360_PaymentType' => $row[11],
            'HistoryDateTime' => Carbon::createFromFormat('d/m/Y', $row[12])->format('Y-m-d'),//Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[12])),
            'PaymentValidationStatus' => $row[13],
            'TrackingNumber' => $row[14],
            'TrackingNumberAmmount' => $row[15],
            'BankName' => $row[16],
            'AccountNumber' => $row[17],
            'Initial_TotalAmountPaid' => $row[18],
            'Final_TotalAmountPaid' => $row[19],
        ]);

        $this->import_result->row_last_processed = $currentRowNumber;
        //$this->import_result->imported = 1; //($this->import_result->nb_rows == $currentRowNumber);
        $this->import_result->save();

        $this->nextRow();

        return $new_encaissement;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    private function nextRow() {
        //$this->rownum++;
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $totalRows = $event->getReader()->getTotalRows();

                foreach ($totalRows as $row) {
                    $this->totalRows = $row;
                }
            }
        ];
    }

    /**
     * @param Failure[] $failures
     */
    public function onFailure(Failure ...$failures)
    {
        // Handle the failures how you'd like.
    }

    public function rules(): array
    {
        return [];
    }
}
