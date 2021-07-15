<?php

namespace App\Console\Commands\Cheque;

use App\Models\ChequesFile;
use App\Imports\ChequesImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ChequeImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cheque:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $raw_dir = config('app.RAW_FOLDER');

        $chequesfiles = ChequesFile::whereHas('fileimportresult', function($q) {
            $q->where('imported', 0)->where('import_processing', 0);
        })->get();

        $nb_to_import = 1;
        $nb_to_imported = 0;
        foreach ($chequesfiles as $chequesfile) {
            if ($nb_to_imported < $nb_to_import) {
                $chequesfile->fileimportresult->update([
                    'import_processing' => 1,
                ]);
                Excel::import(new ChequesImport($chequesfile->fileimportresult), $raw_dir . '/' . config('app.cheques_files') . '/' . $chequesfile->fichier);
                $chequesfile->fileimportresult->update([
                    'import_processing' => 0,
                ]);
            }
            $nb_to_imported++;
        }
        return 0;
    }
}
