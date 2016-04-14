<?php
namespace Rolice\Econt\Components;

/**
 * Class Instruction
 * Class representing single instruction for loading in courier service
 * @package Rolice\Econt\Component
 * @version 0.1a
 * @access public
 * @todo Very basic instruction class only used for return address, for payment of failed delivery.
 */
class Instruction implements ComponentInterface
{

    use Serializable;

    const TYPE_TAKE = 'take';
    const TYPE_GIVE = 'give';
    const TYPE_RETURN = 'return';

    const FAIL_ACTION_CONTACT = 'contact';
    const FAIL_ACTION_INSTRUCTION = 'instruction';
    const FAIL_ACTION_RETURN_SENDER = 'return_to_sender';
    const FAIL_ACTION_RETURN_ADDRESS = 'return_to_address';
    const FAIL_ACTION_RETURN_OFFICE = 'return_to_office';

    public $type;
    public $delivery_fail_action;
    public $reject_delivery_payment_side;
    public $reject_return_payment_side;

    public function tag()
    {
        return 'e';
    }

}