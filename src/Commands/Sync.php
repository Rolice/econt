<?php
namespace Rolice\Econt\Commands;

use App;
use Illuminate\Console\Command;

use Rolice\Econt\Models\City;
use Rolice\Econt\Models\Country;
use Rolice\Econt\Models\Region;
use Rolice\Econt\Models\Zone;

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
        $this->comment(PHP_EOL . 'Importing zones... Please wait.');

        foreach (App::make('Econt')->zones() as $zone) {
            (new Zone)->import($zone);
        }

        $this->comment(PHP_EOL . 'Zones imported successfully.');

        $this->comment(PHP_EOL . 'Importing settlements... Please wait.');

        foreach (App::make('Econt')->settlements() as $settlement) {
            (new Settlement)->import($settlement);
        }

        $this->comment(PHP_EOL . 'Settlements imported successfully.');

        $this->comment(PHP_EOL . 'Importing regions... Please wait.');

        foreach (App::make('Econt')->regions() as $region) {
            (new Region)->import($region);
        }

        $this->comment(PHP_EOL . 'Regions imported successfully.' . PHP_EOL);
    }
}