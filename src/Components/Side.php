<?php
namespace Rolice\Econt\Components;

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

}