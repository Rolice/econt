<?php
namespace Rolice\Econt\Http\Controllers;

use App\Http\Controllers\Controller;
use Rolice\Econt\Econt;
use Rolice\Econt\Waybill;

class WaybillController extends Controller
{

    public function issue()
    {
        $waybill = Waybill::issue();
    }

}