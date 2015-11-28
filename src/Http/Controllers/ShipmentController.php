<?php
namespace Rolice\Econt\Http\Controllers;

use App;
use Lang;
use Input;

use App\Http\Controllers\Controller;

class ShipmentController extends Controller
{

    public function index()
    {
        return [
            'results' => [
                ['id' => 'PACK', 'name' => Lang::get('econt::shipment.type.pack')],
                ['id' => 'DOCUMENT', 'name' => Lang::get('econt::shipment.type.document')],
                ['id' => 'PALLET', 'name' => Lang::get('econt::shipment.type.pallet')],
                ['id' => 'CARGO', 'name' => Lang::get('econt::shipment.type.cargo')],
                ['id' => 'DOCUMENTPALLET', 'name' => Lang::get('econt::shipment.type.documentpallet')],
            ],
            'more' => false,
        ];
    }
}