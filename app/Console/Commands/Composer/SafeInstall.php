<?php

namespace App\Console\Commands\Composer;

use Illuminate\Console\Command;

class SafeInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'composer:safeinstall';

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
        exec('composer install --ignore-platform-reqs');
        $this->info('Composer Install OK');
    }
}
