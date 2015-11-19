<?php
namespace Rolice\Econt;

use Rolice\Econt\Exceptions\EcontException;

/**
 * Class Endpoint
 * Class with constants, providing end-point addresses to Econt services.
 * @package Rolice\Econt
 * @version 0.1
 * @access public
 */
class Endpoint
{
    const PARCEL = 'http://econt.com/e-econt/xml_parcel_import2.php';
    const SERVICE = 'http://econt.com/e-econt/xml_service_tool.php';

    const PARCEL_DEMO = 'http://demo.econt.com/e-econt/xml_parcel_import2.php';
    const SERVICE_DEMO = 'http://demo.econt.com/e-econt/xml_service_tool.php';

    public static function parcel()
    {
        return 'production' !== env('ENVIRONMENT', 'production') ? self::PARCEL : self::PARCEL_DEMO;
    }

    public static function service()
    {
        return 'production' !== env('ENVIRONMENT', 'production') ? self::SERVICE : self::SERVICE_DEMO;
    }

}