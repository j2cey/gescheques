<?php

namespace App\Console\Commands\Aris;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConnectionTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aris:connection.test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test la connecxion a la base de données ARIS';

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
        if (DB::connection('sqlsrv')->getDatabaseName())
        {
            $this->info('Connected to the DB: ' . DB::connection('sqlsrv')->getDatabaseName());
        } else {
            $this->info('Connection Failed');
        }
    }
}
