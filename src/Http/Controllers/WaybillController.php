<?php
namespace Rolice\Econt\Http\Controllers;

use App\Http\Controllers\Controller;
use Rolice\Econt\Components\Loading;
use Rolice\Econt\Components\Receiver;
use Rolice\Econt\Components\Sender;
use Rolice\Econt\Components\Services;
use Rolice\Econt\Components\Shipment;
use Rolice\Econt\Components\Payment;
use Rolice\Econt\Econt;
use Rolice\Econt\Waybill;

class WaybillController extends Controller
{

    public function issue()
    {
        $sender = new Sender;
        $receiver = new Receiver;
        $shipment = new Shipment;
        $payment = new Payment;
        $services = new Services;

        $loading = new Loading($sender, $receiver, $shipment, $payment, $services);

        return $loading->serialize();

        // $waybill = Waybill::issue();
    }

}