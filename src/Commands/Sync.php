<?php
namespace Rolice\Econt\Commands;

use DB;
use App;
use Illuminate\Console\Command;

use Rolice\Econt\Models\Neighbourhood;
use Rolice\Econt\Models\Settlement;
use Rolice\Econt\Models\Street;
use Rolice\Econt\Models\Region;
use Rolice\Econt\Models\Office;
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
        DB::connection('econt')->disableQueryLog();

        $this->comment(PHP_EOL . 'Importing zones... Please wait.');

        Zone::whereRaw(1)->delete();

        foreach (App::make('Econt')->zones() as $zone) {
            (new Zone)->import($zone);
        }

        $this->comment(PHP_EOL . 'Zones imported successfully.');

        $this->comment(PHP_EOL . 'Importing settlements... Please wait.');

        Settlement::whereRaw(1)->delete();

        foreach (App::make('Econt')->settlements() as $settlement) {
            (new Settlement)->import($settlement);
        }

        $this->comment(PHP_EOL . 'Settlements imported successfully.');

        $this->comment(PHP_EOL . 'Importing regions... Please wait.');

        Region::whereRaw(1)->delete();

        foreach (App::make('Econt')->regions() as $region) {
            (new Region)->import($region);
        }

        $this->comment(PHP_EOL . 'Regions imported successfully.' . PHP_EOL);

        $this->comment(PHP_EOL . 'Importing neighbourhoods... Please wait.');

        Neighbourhood::whereRaw(1)->delete();

        foreach (App::make('Econt')->neighbourhoods() as $region) {
            (new Neighbourhood)->import($region);
        }

        $this->comment(PHP_EOL . 'Neighbourhoods imported successfully.' . PHP_EOL);

        $this->comment(PHP_EOL . 'Importing streets... Please wait.');

        Street::whereRaw(1)->delete();

        foreach (App::make('Econt')->streets() as $region) {
            (new Street)->import($region);
        }

        $this->comment(PHP_EOL . 'Streets imported successfully.' . PHP_EOL);

        $this->comment(PHP_EOL . 'Importing offices... Please wait.');

        Office::whereRaw(1)->delete();

        foreach (App::make('Econt')->offices() as $region) {
            (new Office)->import($region);
        }

        $this->comment(PHP_EOL . 'Offices imported successfully.' . PHP_EOL);
    }

}