<?php
namespace Rolice\Econt;

use Rolice\Econt\Exceptions\EcontException;

/**
 * Class RequestType
 * Class with constants, providing valid, predefined Econt request types.
 * @package Rolice\Econt
 * @version 1.0
 * @access public
 */
class RequestType
{
    const NONE = null;
    const REGISTRATION = 'e_econt_registration';
    const PROFILE = 'client_info';
    const ZONES = 'cities_zones';
    const REGIONS = 'cities_regions';
    const STREETS = 'cities_streets';
    const SHIPMENTS = 'shipments';
    const SHIPPING = 'shipping';
    const CITIES = 'cities';
    const CANCELLATION = 'cancel_shipments';
    const NEIGHBOURHOODS = 'cities_quarters';
    const OFFICES = 'offices';
    const CLIENTS = 'access_clients';
    const DELIVERY = 'delivery_days';

}