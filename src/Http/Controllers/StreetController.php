<?php
namespace Rolice\Econt\Http\Controllers;

use App;
use Input;

use App\Http\Controllers\Controller;
use Rolice\Econt\Models\Street;

class StreetController extends Controller
{

    const MIN_AUTOCOMPLETE_LENGTH = 3;

    public function index()
    {
        return Street::orderBy('name')->get();
    }

    public function autocomplete()
    {
        $settlement = (int)Input::get('settlement');
        $name = htmlentities(Input::get('query'), ENT_QUOTES, 'UTF-8', false);

        if (0 >= $settlement || self::MIN_AUTOCOMPLETE_LENGTH > mb_strlen($name)) {
            return ['results' => [], 'more' => false];
        }

        $result = Street::where('city_id', $settlement)
            ->whereNested(function ($query) use ($name) {
                $query->where('name', 'LIKE', "%$name%")->orWhere('name_en', 'LIKE', "%$name%");
            })
            ->get(['id', 'bg' === App::getLocale() ? 'name' : 'name_en AS name']);

        return [
            'results' => $result,
            'more' => false,
        ];
    }

}