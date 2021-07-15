<?php

namespace App\Console\Commands\Encaissement;

use Illuminate\Console\Command;
use App\Models\EncaissementsFile;
use App\Imports\EncaissementsImport;
use Maatwebsite\Excel\Facades\Excel;

class EncaissementImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encaissement:import';

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

        $encaissementsfiles = EncaissementsFile::whereHas('fileimportresult', function($q) {
            $q->where('imported', 0)->where('import_processing', 0);
        })->get();

        $nb_to_import = 1;
        $nb_to_imported = 0;
        foreach ($encaissementsfiles as $encaissementsfile) {
            if ($nb_to_imported < $nb_to_import) {
                $encaissementsfile->fileimportresult->update([
                    'import_processing' => 1,
                ]);
                Excel::import(new EncaissementsImport($encaissementsfile->fileimportresult), $raw_dir . '/' . config('app.encaissements_files') . '/' . $encaissementsfile->fichier);
                $encaissementsfile->fileimportresult->update([
                    'import_processing' => 0,
                ]);
            }
            $nb_to_imported++;
        }
        return 0;
    }
}
