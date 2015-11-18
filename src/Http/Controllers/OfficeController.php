<?php
namespace Rolice\Econt\Http\Controllers;

use Input;

use App\Http\Controllers\Controller;
use Rolice\Econt\Models\Office;
use Rolice\Econt\Helpers\Locale;

class OfficeController extends Controller
{

    const MIN_AUTOCOMPLETE_LENGTH = 3;

    public function index()
    {
        return Office::orderBy(Locale::name())->get();
    }

    public function dropdown()
    {
        return Office::orderBy(Locale::name())->lists('name', 'id');
    }

    public function autocomplete()
    {
        $lang = Input::get('lang');
        $settlement = (int)Input::get('settlement');
        $name = htmlentities(Input::get('query'), ENT_QUOTES, 'UTF-8', false);

        if (0 >= $settlement) {
            return ['results' => [], 'more' => false];
        }

        $result = Office::where('city_id', $settlement)
            ->whereNested(function ($query) use ($name) {
                $query->where('name', 'LIKE', "%$name%")->orWhere('name_en', 'LIKE', "%$name%");
            })
            ->get(['id', 'bg' === $lang ? 'name' : 'name_en AS name']);

        return [
            'results' => $result,
            'more' => false,
        ];
    }

}