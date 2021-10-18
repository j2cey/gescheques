<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Cheque;
use App\Models\Bordereau;
use App\Models\FileImportResult;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeImport;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;

class ChequesImport implements ToModel, WithChunkReading, WithEvents
{
    use RemembersRowNumber;

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
    * @return Model|null
    */
    public function model(array $row)
    {
        $currentRowNumber = $this->getRowNumber();

        if ($currentRowNumber == 1) {
            $this->nextRow();;
            return null;
        }

        if ($currentRowNumber < $this->import_result->row_last_processed) {
            $this->nextRow();
            return null;
        }

        $max_cheques_by_bordereau = 10;

        if ($currentRowNumber == 2) {
            $bordereau = Bordereau::create();
        } else {
            $last_cheque = Cheque::latest('id')->first();

            if ( Cheque::where('bordereau_id','=', $last_cheque->bordereau_id)->count() == $max_cheques_by_bordereau ) {
                $bordereau = Bordereau::create();
            } else {
                $bordereau = Bordereau::where('id', $last_cheque->bordereau_id)->first();
            }
        }

        $new_cheque = new Cheque([
            'NREC_BANK_MVT_ID' => $row[0],
            'ACC_CODE' => $row[1],
            'BANK_FLOW_CODE' => $row[2],
            'ABK_CUR_AMOUNT' => $row[3],
            'ABK_CUR_CODE' => $row[4],
            'TRN_FLAG' => $row[5],
            'TRN_AMOUNT' => $row[6],
            'TRN_CUR' => $row[7],
            'CHEQUE_NB' => $row[8],
            'BOOK_DATE' => $row[9], //Carbon::parse($row[9]),//Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[9])),
            'VALUE_DATE' => $row[10], //Carbon::parse($row[10]),//Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[10])),
            'DESCRIPTION' => $row[11],
            'COMPLEMENTS1' => $row[12],
            'COMPLEMENTS2' => $row[13],
            'COMPLEMENTS3' => $row[14],
            'COMPLEMENTS4' => $row[15],
            'COMPLEMENTS7' => $row[16],
            'COMPLEMENTS5' => $row[17],
            'COMPLEMENTS8' => $row[18],
            'COMPLEMENTS9' => $row[19],
            'COMPLEMENTS10' => $row[20],
            'COMPLEMENTS6' => $row[21],
            'COMPLEMENTS11' => $row[22],
            'COMPLEMENTS12' => $row[23],
            'COMPLEMENTS13' => $row[24],
            'COMPLEMENTS14' => $row[25],
            'COMPLEMENTS15' => $row[26],
            'COMPLEMENTS16' => $row[27],
            'COMPLEMENTS17' => $row[28],
            'COMPLEMENTS18' => $row[29],
            'COMPLEMENTS19' => $row[31],
            'COMPLEMENTS20' => $row[32],
            'COMPLEMENTS21' => $row[33],
            'COMPLEMENTS22' => $row[34],
            'COMPLEMENTS23' => $row[35],
            'COMPLEMENTS24' => $row[36],
            'SENSE_FLAG' => $row[37],
            'EURO_GAP_FLAG' => $row[38],
            'BANK_CUR_AMOUNT' => $row[39],
            'BANK_CUR_CODE' => $row[40],
            'INTERNAL_MVT_ID' => $row[41],
            'IMPORT_PROCESS_LOG_ID' => $row[42],
            'IMPORT_DATE' => $row[43], //Carbon::parse($row[43]),//Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[43])),
            'HISTORY_ID' => $row[44],
            'CALCULATION_METHOD' => $row[45],
            'EXEMPT_FLAG' => $row[46],
            'EXTRACT_FLAG' => $row[47],
            'PRE_REC_ID' => $row[48],
            'UNREC_DATE' => $row[49], //Carbon::parse($row[49]),//Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[49])),
            'REC_TEMP_FLAG' => $row[50],
            'NOT_DIRTY_FLAG' => $row[51],
            'ZU_01' => $row[52],
            'ZU_02' => $row[53],
            'ZU_03' => $row[54],
            'ZU_04' => $row[55],
            'ZU_05' => $row[56],
            'ZU_06' => $row[57],
            'ZU_07' => $row[58],
            'ZU_08' => $row[59],
            'ZU_09' => $row[60],
            'ZU_10' => $row[61],
            'ROWVERSION' => $row[62],

            'bordereau_id' => $bordereau->id,
        ]);

        $this->nextRow();

        return $new_cheque;
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
}
