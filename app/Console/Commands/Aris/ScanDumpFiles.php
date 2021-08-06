<?php

namespace App\Console\Commands\Aris;

use Illuminate\Console\Command;
use App\Models\EncaissementsFile;
use App\Traits\File\FilesScanning;

class ScanDumpFiles extends Command
{
    use FilesScanning;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aris:scan.dumps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan et enregistre les dumps Aris déposés';

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
        $sftp_path = "/var/sftp/files/arisdumps";
        $new_files = $this->moveFiles($sftp_path, "encaissements_files", true);

        if ( ! empty($new_files)) {
            foreach ($new_files as $key => $file) {
                $encaissemen_file = new EncaissementsFile();
                $encaissemen_file->save();

                $encaissemen_file->createFile($key, 'file', 'encaissements_files', $file);
            }
        }
    }
}
