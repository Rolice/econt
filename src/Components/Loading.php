<?php
namespace Rolice\Econt\Components;

/**
 * Class Loading
 * Class representing single load for courier service
 * @package Rolice\Econt\Component
 * @version 0.7
 * @access public
 */
class Loading implements ComponentInterface
{

    use Serializable;

    /**
     * The sender of this load
     * @var Sender
     */
    protected $sender;

    /**
     * The receiver of this load
     * @var Receiver
     */
    protected $receiver;

    /**
     * The shipment of this load
     * @var Shipment
     */
    protected $shipment;

    /**
     * Payment information for this load
     * @var Payment
     */
    protected $payment;

    /**
     * The services set for this load
     * @var Services
     */
    protected $services;

    /**
     * The courier request for this load
     * @var CourierRequest
     */
    protected $courier_request;

    public function __construct(
        Sender $sender,
        Receiver $receiver,
        Shipment $shipment,
        Payment $payment,
        Services $services,
        CourierRequest $courier = null
    ) {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->shipment = $shipment;
        $this->payment = $payment;
        $this->services = $services;
        $this->instructions = new Instructions;

        if ($courier) {
            $this->courier_request = $courier;
        }
    }

    public function tag()
    {
        return 'row';
    }

}