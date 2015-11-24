<?php
namespace Rolice\Econt\Http\Controllers;

use App;
use Input;

use App\Http\Controllers\Controller;
use Rolice\Econt\Models\Office;
use Rolice\Econt\Helpers\Locale;
use Rolice\Econt\Models\Settlement;

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
        $settlement = (int)Input::get('settlement');
        $name = htmlentities(Input::get('query'), ENT_QUOTES, 'UTF-8', false);

        if (0 >= $settlement) {
            return ['results' => [], 'more' => false];
        }

        $result = Office::where('city_id', $settlement)
            ->whereNested(function ($query) use ($name) {
                $query->where('name', 'LIKE', "%$name%")->orWhere('name_en', 'LIKE', "%$name%");
            })
            ->get(['id', 'bg' === App::getLocale() ? 'name' : 'name_en AS name']);

        return [
            'results' => $result,
            'more' => false,
        ];
    }

    public function autocompleteBySettlementName()
    {
        $settlement = htmlentities(Input::get('settlement'), ENT_QUOTES, 'UTF-8', false);
        $name = htmlentities(Input::get('query'), ENT_QUOTES, 'UTF-8', false);

        $settlement = Settlement::where('name', 'LIKE', "$settlement%")->orWhere('name_en', 'LIKE', "$settlement%")->first();

        if (!$settlement) {
            return ['results' => [], 'more' => false];
        }

        $result = Office::where('city_id', $settlement->id)
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