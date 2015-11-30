<?php
namespace Rolice\Econt\Components;

class Payment implements ComponentInterface
{

    use Serializable;

    const SENDER = 'SENDER';
    const RECEIVER = 'RECEIVER';

    const COD = 'CASH';
    const CREDIT = 'CREDIT';
    const BONUS = 'BONUS';
    const VOUCHER = 'VOUCHER';

    public $side;
    public $method;

    public $receiver_share_sum;
    public $share_percent;
    public $key_word;

    public function __construct($side = self::SENDER, $method = self::COD)
    {
        $this->side = $side;
        $this->method = $method;
    }

}