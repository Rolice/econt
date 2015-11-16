<?php
namespace Rolice\Econt\Http\Controllers;

use App\Http\Controllers\Controller;
use Rolice\Econt\Models\Neighbourhood;
use Rolice\Econt\Models\Office;
use Rolice\Econt\Models\Settlement;
use Rolice\Econt\Models\Street;
use Rolice\Econt\Models\Zone;

class EcontController extends Controller
{
    public function zones()
    {
        return Zone::orderBy('name')->get();
    }

    public function settlements()
    {
        return Settlement::with('country')->orderBy('name')->limit(10)->get();
    }

    public function neighbourhoods()
    {
        return Neighbourhood::orderBy('name')->get();
    }

    public function streets()
    {
        return Street::orderBy('name')->get();
    }

    public function offices()
    {
        return Office::orderBy('name')->get();
    }
}