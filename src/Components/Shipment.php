<?php
namespace Rolice\Econt\Components;

class Shipment implements ComponentInterface
{

    use Serializable;

    const SHIPPING_RETURNS = 'shipping_returns';
    const RETURNS = 'returns';

    public $weight;
    public $currency;
    public $envelope_num;
    public $shipment_type;
    public $description;
    public $pack_count;
    public $send_date;
    public $tariff_code;
    public $tariff_sub_code;
    public $pay_after_accept;
    public $pay_after_test;
    public $instruction_returns;
    public $invoice_before_pay_CD;

    public function setTrariffSubCode($sender_pickup, $receiver_pickup)
    {
        $sender = 'office' === $sender_pickup ? 'OFFICE' : 'DOOR';
        $receiver = 'office' === $receiver_pickup ? 'OFFICE' : 'DOOR';

        $this->tariff_sub_code = "{$sender}_{$receiver}";
    }

}