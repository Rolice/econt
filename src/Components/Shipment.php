<?php
namespace Rolice\Econt\Components;

class Shipment implements ComponentInterface
{

    use Serializable;

    public $envelope_num;
    public $shipment_type;
    public $description;
    public $pack_count;
    public $weight;
    public $tariff_code;
    public $tariff_sub_code;
    public $pay_after_accept;

    public function setTrariffSubCode($sender_pickup, $receiver_pickup)
    {
        $sender = 'office' === $sender_pickup ? 'OFFICE' : 'ADDRESS';
        $receiver = 'office' === $receiver_pickup ? 'OFFICE' : 'ADDRESS';

        return "{$sender}_{$receiver}";
    }

}