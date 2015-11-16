<?php
namespace Rolice\Econt\Http\Controllers;

use App\Http\Controllers\Controller;
use Rolice\Econt\Models\Zone;

class EcontController extends Controller
{
    public function zones()
    {
        return Zone::orderBy('name')->get();
    }
}