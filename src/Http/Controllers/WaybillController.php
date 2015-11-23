<?php
namespace Rolice\Econt\Http\Controllers;

use Input;

use App\Http\Controllers\Controller;
use rest\server\user\Load;
use Rolice\Econt\Components\Loading;
use Rolice\Econt\Exceptions\EcontException;
use Rolice\Econt\Http\Requests\WaybillRequest;
use Rolice\Econt\Models\Office;
use Rolice\Econt\Models\Settlement;
use Rolice\Econt\Components\Payment;
use Rolice\Econt\Components\Receiver;
use Rolice\Econt\Components\Sender;
use Rolice\Econt\Components\Services;
use Rolice\Econt\Components\Shipment;
use Rolice\Econt\Models\Street;
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

        return Waybill::issue($sender, $receiver, $shipment, $payment, $services);
    }

    public function calculate(WaybillRequest $request)
    {
        $sender = $this->_sender();
        $receiver = $this->_receiver();
        $shipment = $this->_shipment();
        $payment = new Payment;
        $services = new Services;

        $loading = new Loading($sender, $receiver, $shipment, $payment, $services);

        return Waybill::calculate($loading);
    }

    protected function _sender()
    {
        $settlement = Settlement::find((int)Input::get('sender.settlement'));

        $sender = new Sender;
        $sender->name = Input::get('sender.name');
        $sender->city = $settlement->name;
        $sender->post_code = $settlement->post_code;
        $sender->phone_num = Input::get('sender.phone');

        switch (Input::get('sender.pickup')) {
            case 'address':
                $sender->street = Street::find((int)Input::get('sender.street'))->name;
                $sender->street_num = Input::get('sender.street_num');
                $sender->street_num = Input::get('sender.street_vh');
                break;

            case 'office':
                $sender->office_code = Office::find((int)Input::get('sender.office'))->code;
                break;
        }

        return $sender;
    }

    protected function _receiver()
    {
        $settlement = Settlement::find((int)Input::get('receiver.settlement'));

        $receiver = new Receiver;
        $receiver->name = Input::get('receiver.name');
        $receiver->city = $settlement->name;
        $receiver->post_code = $settlement->post_code;
        $receiver->phone_num = Input::get('receiver.phone');

        switch (Input::get('receiver.pickup')) {
            case 'address':
                $receiver->street = Street::find((int)Input::get('receiver.street'))->name;
                $receiver->street_num = Input::get('receiver.street_num');
                $receiver->street_num = Input::get('receiver.street_vh');
                break;

            case 'office':
                $receiver->office_code = Office::find((int)Input::get('receiver.office'))->code;
                break;
        }

        return $receiver;
    }

    protected function _shipment()
    {
        $shipment = new Shipment;

        $shipment->envelope_num = Input::get('shipment.num');
        $shipment->shipment_type = Input::get('shipment.type');
        $shipment->description = Input::get('shipment.description');
        $shipment->pack_count = (int) Input::get('shipment.count');
        $shipment->weight = (float) Input::get('shipment.weight');

        $shipment->setTrariffSubCode(Input::get('sender.pickup'), Input::get('receiver.pickup'));

        return $shipment;
    }
}