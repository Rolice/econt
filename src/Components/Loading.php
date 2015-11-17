<?php
namespace Rolice\Econt\Components;

/**
 * Class Loading
 * Class representing single load for courier service
 * @package Rolice\Econt\Component
 * @version 0.1
 * @access public
 */
class Loading implements ComponentInterface
{

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

    public function __construct(
        Sender $sender,
        Receiver $receiver,
        Shipment $shipment,
        Payment $payment,
        Services $services
    ) {
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->shipment = $shipment;
        $this->payment = $payment;
        $this->services = $services;
    }

}