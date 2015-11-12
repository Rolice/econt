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
    protected $description = 'Synchronizes Econt database with the packages one through their API. Caution: Slow operations.';

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