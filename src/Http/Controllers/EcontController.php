<?php
namespace Rolice\Econt\Http\Controllers;

use Input;

use App\Http\Controllers\Controller;
use Rolice\Econt\Components\Loading;
use Rolice\Econt\Components\Receiver;
use Rolice\Econt\Components\Sender;
use Rolice\Econt\Econt;
use Rolice\Econt\Models\Neighbourhood;
use Rolice\Econt\Models\Office;
use Rolice\Econt\Models\Settlement;
use Rolice\Econt\Models\Street;
use Rolice\Econt\Models\Zone;
use Rolice\Econt\Waybill;

class EcontController extends Controller
{
    public function zones()
    {
        return Zone::orderBy('name')->get();
    }

    public function neighbourhoods()
    {
        return Neighbourhood::orderBy('name')->get();
    }

    public function test()
    {
        $username = Input::get('username');
        $password = Input::get('password');

        Econt::setCredentials($username, $password);
        Econt::test();
    }

    public function calculate()
    {
        $sender = new Sender;
        $sender->city = Input::get('sender.settlement');

        $receiver = new Receiver;
        $receiver->city = Settlement::find(Input::get('receiver.settlement'))->name;

        //Waybill::calculate();
    }
}