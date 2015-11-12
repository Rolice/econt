<?php
namespace CloudCart\Econt\Component;

class Payment implements ComponentInterface
{

    use Serializable;

    const SENDER = 'SENDER';
    const RECEIVER = 'RECEIVER';

    const COD = 'CASH';

    public $side;
    public $method;

    public function __construct($side = self::SENDER, $method = self::COD)
    {
        $this->side = $side;
        $this->method = $method;
    }

}