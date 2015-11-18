<?php
namespace Rolice\Econt\Http\Controllers;

use App\Http\Controllers\Controller;
use Rolice\Econt\Models\Neighbourhood;
use Rolice\Econt\Models\Office;
use Rolice\Econt\Models\Settlement;
use Rolice\Econt\Models\Street;
use Rolice\Econt\Models\Zone;

class SettlementController extends Controller
{

    public function index()
    {
        return Settlement::with('country')->orderBy('name')->get();
    }

    public function autocomplete()
    {
        $name = Input::get('query');

        return Settlement::where('name', 'LIKE', "%$name%")->orWhere('name_en', 'LIKE', "%name%")->get();
    }

}