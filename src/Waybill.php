<?php
namespace Rolice\Econt;

use App;

/**
 * Class Waybill
 * Interface exported by this package to allow creating/issuing new Econt waybills for printing.
 * @package Rolice\Econt
 * @version 0.1
 * @access public
 */
class Waybill
{
    public static function issue()
    {
        $data = [
            'system' => [
                'validate' => 0,
                'response_type' => 'JSON',
                'only_calculate' => 1,
            ],
        ];

        $econt = App::make('Econt');
        $waybill = $econt->request(RequestType::SHIPPING, [], Endpoint::PARCEL);
    }
}