<?php
namespace Rolice\Econt\Http\Controllers;

use App\Http\Controllers\Controller;
use Rolice\Econt\Waybill;

class WaybillController extends Controller
{

    public function issue()
    {
        return Waybill::issue();
    }

}