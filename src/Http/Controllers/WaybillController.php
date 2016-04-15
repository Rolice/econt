<?php
namespace Rolice\Econt\Http\Controllers;

use App;
use App\Http\Controllers\Controller;
use DateTime;
use Input;
use League\Flysystem\Exception;
use Rolice\Econt\Components\CourierRequest;
use Rolice\Econt\Components\Instruction;
use Rolice\Econt\Components\Loading;
use Rolice\Econt\Components\Payment;
use Rolice\Econt\Components\Receiver;
use Rolice\Econt\Components\Sender;
use Rolice\Econt\Components\Services;
use Rolice\Econt\Components\Shipment;
use Rolice\Econt\Exceptions\EcontException;
use Rolice\Econt\Http\Requests\CalculateRequest;
use Rolice\Econt\Http\Requests\WaybillRequest;
use Rolice\Econt\Models\Office;
use Rolice\Econt\Models\Settlement;
use Rolice\Econt\Models\Street;
use Rolice\Econt\Waybill;

class WaybillController extends Controller
{

    public function issue(WaybillRequest $request)
    {
        $sender = $this->_sender();
        $receiver = $this->_receiver();
        $shipment = $this->_shipment();
        $courier = $this->_courier($shipment);
        $payment = $this->_payment();
        $services = $this->_services();

        if (($username = Input::get('client.username')) && ($password = Input::get('client.password'))) {
            App::make('Econt')->setCredentials($username, $password);
        }


        $loading = new Loading($sender, $receiver, $shipment, $payment, $services, $courier);

        $instruction = new Instruction;
        $instruction->type = Instruction::TYPE_RETURN;
        $instruction->delivery_fail_action = Instruction::FAIL_ACTION_RETURN_SENDER;

        switch (Input::get('shipment.instruction_returns')) {
            case Shipment::RETURNS:
                $instruction->reject_delivery_payment_side = Receiver::SIDE;
                $instruction->reject_return_payment_side = Sender::SIDE;
                break;

            case Shipment::SHIPPING_RETURNS:
                $instruction->reject_delivery_payment_side = Sender::SIDE;
                $instruction->reject_return_payment_side = Sender::SIDE;
                break;

            default:
                $instruction->reject_delivery_payment_side = Receiver::SIDE;
                $instruction->reject_return_payment_side = Receiver::SIDE;
                break;
        }

        $decline_delivery = Input::get('instructions.reject_delivery_payment_side');
        $decline_returns = Input::get('instructions.reject_return_payment_side');

        if ($decline_delivery && in_array($decline_delivery, [Sender::SIDE, Receiver::SIDE])) {
            $instruction->reject_delivery_payment_side = $decline_delivery;
        }

        if ($decline_returns && in_array($decline_returns, [Sender::SIDE, Receiver::SIDE])) {
            $instruction->reject_return_payment_side = $decline_returns;
        }


        $loading->instructions = ['e' => $instruction];

        return Waybill::issue($loading);
    }

    public function calculate(CalculateRequest $request)
    {
        $sender = $this->_senderCalc();
        $receiver = $this->_receiverCalc();
        $shipment = $this->_shipment();
        $payment = $this->_payment();
        $services = $this->_services();

        if (($username = Input::get('client.username')) && ($password = Input::get('client.password'))) {
            App::make('Econt')->setCredentials($username, $password);
        }

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
                $sender->street_vh = Input::get('sender.street_vh');
                $sender->street_et = Input::get('sender.street_et');
                $sender->street_ap = Input::get('sender.street_ap');
                $sender->street_other = Input::get('sender.street_other');
                break;

            case 'office':
                $sender->office_code = Office::find((int)Input::get('sender.office'))->code;
                break;
        }

        return $sender;
    }

    protected function _senderCalc()
    {
        $settlement = Settlement::find((int)Input::get('sender.settlement'));

        $sender = new Sender;
        $sender->city = $settlement->name;
        $sender->post_code = $settlement->post_code;

        switch (Input::get('sender.pickup')) {
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
                $receiver->street_vh = Input::get('receiver.street_vh');
                $receiver->street_et = Input::get('receiver.street_et');
                $receiver->street_ap = Input::get('receiver.street_ap');
                $receiver->street_other = Input::get('receiver.street_other');
                break;

            case 'office':
                $receiver->office_code = Office::find((int)Input::get('receiver.office'))->code;
                break;
        }

        return $receiver;
    }

    protected function _receiverCalc()
    {
        $receiver = new Receiver;
        $receiver->city = Input::get('receiver.settlement');
        $receiver->post_code = Input::get('receiver.post_code');

        switch (Input::get('receiver.pickup')) {
            case 'office':
                $receiver->office_code = Office::find((int)Input::get('receiver.office'))->code;
                break;
        }

        return $receiver;
    }


    protected function _shipment()
    {
        $instruction_returns = Input::get('shipment.instruction_returns');

        if (!in_array($instruction_returns, [Shipment::RETURNS, Shipment::SHIPPING_RETURNS])) {
            $instruction_returns = null;
        }

        $shipment = new Shipment;

        $shipment->envelope_num = Input::get('shipment.num');
        $shipment->shipment_type = Input::get('shipment.type');
        $shipment->description = Input::get('shipment.description');
        $shipment->pack_count = (int)Input::get('shipment.count');
        $shipment->weight = (float)Input::get('shipment.weight');
        $shipment->pay_after_accept = (int)!!Input::get('shipment.pay_after_accept');
        $shipment->pay_after_test = (int)!!Input::get('shipment.pay_after_test');
        $shipment->instruction_returns = $instruction_returns;
        $shipment->invoice_before_pay_CD = (int)!!Input::get('shipment.invoice_before_pay');

        $shipment->setTrariffSubCode(Input::get('sender.pickup'), Input::get('receiver.pickup'));

        return $shipment;
    }

    protected function _courier(Shipment &$shipment)
    {
        $date = Input::get('courier.date');
        $from = Input::get('courier.time_from');
        $to = Input::get('courier.time_to');

        if (!$date) {
            return null;
        }

        $from = DateTime::createFromFormat('Y-m-d H:i', "$date $from");
        $to = DateTime::createFromFormat('Y-m-d H:i', "$date $to");

        if (!$from || !$to) {
            return null;
        }

        $courier = new CourierRequest($shipment, $from, $to);

        return $courier;
    }

    protected function _payment()
    {
        $payment = new Payment(PAYMENT::RECEIVER === Input::get('payment.side') ? Payment::RECEIVER : Payment::SENDER);
        return $payment;
    }

    protected function _services()
    {
        $dp = Input::get('services.dp');
        $cd = (float)Input::get('services.cd');
        $oc = (float)Input::get('services.oc');
        $oc_currency = Input::get('services.oc_currency');
        $cd_currency = Input::get('services.cd_currency');


        $services = new Services;
        $services->dp = $dp ? 'ON' : null;

        $services->oc = 0 < $oc && preg_match('#[A-Z]{3}#', $oc_currency) ? $oc : null;
        $services->oc_currency = 0 < $oc && preg_match('#[A-Z]{3}#', $oc_currency) ? $oc_currency : null;

        $services->cd = 0 < $cd && preg_match('#[A-Z]{3}#', $cd_currency) ? $cd : null;
        $services->cd_currency = 0 < $cd && preg_match('#[A-Z]{3}#', $cd_currency) ? $cd_currency : null;

        return $services;
    }
}