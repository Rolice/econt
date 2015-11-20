<?php
namespace Rolice\Econt\Http\Controllers;

use Input;

use App\Http\Controllers\Controller;
use Rolice\Econt\Models\Settlement;

class SettlementController extends Controller
{

    const MIN_AUTOCOMPLETE_LENGTH = 3;

    public function index()
    {
        return Settlement::with('country')->orderBy('name')->get();
    }

    public function autocomplete()
    {
        $lang = Input::get('lang');
        $name = htmlentities(Input::get('query'), ENT_QUOTES, 'UTF-8', false);

        if (self::MIN_AUTOCOMPLETE_LENGTH > mb_strlen($name)) {
            return ['results' => [], 'more' => false];
        }

        $settlements = Settlement::where('name', 'LIKE', "%$name%")->orWhere('name_en', 'LIKE', "%$name%")->get([
            'id',
            'type',
            'name',
            'name_en',
            'post_code',
        ]);
        $result = [];

        foreach ($settlements as $settlement) {
            $name_col = 'bg' === $lang ? 'name' : 'name_en';
            $entry = [ 'id' => $settlement->id, 'name' => $settlement->$name_col ];

            $entry['name'] = "{$entry['name']} ({$settlement->post_code})";

            $result[] = (object) $entry;
        }

        return [
            'results' => $result,
            'more' => false,
        ];
    }

}