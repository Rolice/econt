<?php
namespace Rolice\Econt\Http\Controllers;

use App\Http\Controllers\Controller;
use Rolice\Econt\Models\Neighbourhood;
use Rolice\Econt\Models\Office;
use Rolice\Econt\Models\Settlement;
use Rolice\Econt\Models\Street;
use Rolice\Econt\Models\Zone;

class OfficeController extends Controller
{
    public function index()
    {
        return Office::orderBy('name')->get();
    }

    public function dropdown() {
        return Office::orderBy('name')->lists('name', 'id');
    }
}