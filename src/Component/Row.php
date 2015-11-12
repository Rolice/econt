<?php
namespace Rolice\Econt\Component;

/**
 * Class Row
 * Class representing single load for courier service
 * @package Rolice\Econt\Component
 * @version 0.1
 * @access public
 */
class Row implements ComponentInterface
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

    public function serialize()
    {
        return [
            'sender' => $this->sender->serialize(),
            'receiver' => $this->receiver->serialize(),
            'shipment' => $this->shipment->serialize(),
            'payment' => $this->payment->serialize(),
            'services' => $this->services->serialize(),
        ];
    }

}