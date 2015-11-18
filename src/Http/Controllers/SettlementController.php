<?php
namespace Rolice\Econt\Http\Controllers;

use Input;

use App\Http\Controllers\Controller;
use Rolice\Econt\Models\Settlement;

class SettlementController extends Controller
{

    public function index()
    {
        return Settlement::with('country')->orderBy('name')->get();
    }

    public function autocomplete()
    {
        $name = htmlentities(Input::get('query'), ENT_QUOTES, 'UTF-8', false);

        return Settlement::where('name', 'LIKE', "%$name%")->orWhere('name_en', 'LIKE', "%$name%")->get();
    }

}