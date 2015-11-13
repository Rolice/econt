<?php
namespace Rolice\Econt\Commands;

use Illuminate\Console\Command;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'econt:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronizes the database with the Econt\'s one through their API. Caution: This is slow operation with heavy load.';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @codeCoverageIgnore
     */
    public function handle()
    {
        $this->comment(PHP_EOL . 'ECONT!' . PHP_EOL);
    }
}