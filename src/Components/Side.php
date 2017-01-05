<?php
namespace Rolice\Econt\Components;

/**
 * Class Side
 * Legal side on courier service, used for senders, receivers and 3rd-party sides
 * @package Rolice\Econt\Component
 * @version 1.0
 * @access public
 */
abstract class Side implements ComponentInterface
{

    use Serializable;

    public $city;
    public $post_code;
    public $office_code;
    public $name;
    public $name_person;
    public $quarter;
    public $street;
    public $street_num;
    public $street_bl;
    public $street_vh;
    public $street_et;
    public $street_ap;
    public $street_other;
    public $phone_num;
    public $sms_no;
    public $phone;
    public $email;

}
