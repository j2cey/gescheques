<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Traits\BordereauremiseFile\ScanFilesTrait;

class BordereauRemiseScanFiles extends Command
{
    use ScanFilesTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'borderemise:scanfiles';

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
        $nb_files = $this->scanFiles();
        if ($nb_files > 0) {
            $exec_msg = "borderemise:scanfiles Traitement termine. " . $nb_files . " scannes et pret pour importation";
            \Log::info($exec_msg);
            $this->info(str_replace("borderemise:scanfiles ", "", $exec_msg));
        }
        return 0;
    }
}
