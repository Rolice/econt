<?php
namespace Rolice\Econt;

use App;

use Rolice\Econt\Components\Loading;
use Rolice\Econt\Components\Sender;
use Rolice\Econt\Components\Receiver;
use Rolice\Econt\Components\Shipment;
use Rolice\Econt\Components\Payment;
use Rolice\Econt\Components\Services;

/**
 * Class Waybill
 * Interface exported by this package to allow creating/issuing new Econt waybills for printing.
 * @package Rolice\Econt
 * @version 0.1
 * @access public
 */
class Waybill
{
    public static function issue(Sender $sender, Receiver $receiver, Shipment $shipment, Payment $payment, Services $services)
    {
        $data = [
            'system' => [
                'validate' => 0,
                'response_type' => 'JSON',
                'only_calculate' => 1,
            ],

            'loadings' => [
                new Loading($sender, $receiver, $shipment, $payment, $services),
            ],
        ];

        $econt = App::make('Econt');
        $waybill = $econt->request(RequestType::SHIPPING, $data, Endpoint::PARCEL);

        return $waybill;
    }
}