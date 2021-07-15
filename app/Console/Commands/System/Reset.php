<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Reset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:reset';

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
        exec('rm -rf public/uploads/cheques/files/*.xlsx');
        exec('rm -rf public/uploads/cheques/scans/*');
        exec('rm -rf public/uploads/encaissements/files/*.xlsx');

        Artisan::call('migrate:reset');

        $this->info('System reset OK');
    }
}
