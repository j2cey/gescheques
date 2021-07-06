<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BordereauremiseFile;
use App\Traits\BordereauremiseFile\ImportFileTrait;

class BordereauRemiseImportFiles extends Command
{
    use ImportFileTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'borderemise:importfiles';

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
        $nb_max_lines = config('Settings.bordereaux_remise.importation.nb_max_lines');
        $file_to_import = BordereauremiseFile::where('imported', 0)->where('import_processing', 0)->whereNull('suspended_at')->first();

        if ($file_to_import) {
            $file_to_import->import($nb_max_lines);
            //event(new SmsresultEvent($file_to_import->planning->campaign->smsresult));
            \Log::info("borderemise:importfiles Traitement termine.");
            $this->info('borderemise:importfiles execute avec succes! ' . $nb_max_lines . ' ligne(s) traitée(s).');
        } else {
            $this->info('Aucun fichier a traiter.');
        }
        return 0;
    }
}
