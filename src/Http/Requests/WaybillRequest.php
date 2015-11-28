<?php
namespace Rolice\Econt\Http\Requests;

use Input;
use Config;
use App\Http\Requests\Request;
use Rolice\Econt\Exceptions\EcontException;

class WaybillRequest extends Request {

    public function authorize()
    {
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $db = Config::get('econt.connection');

        $rules = [
            'sender.name' => 'required',
            'sender.phone' => 'required',
            'sender.settlement' => "required|integer|exists:$db.econt_settlements,id",
            'sender.pickup' => 'required|in:address,office',
            'sender.street' => "required_if:sender.pickup,address|exists:$db.econt_streets,id",
            'sender.street_num' => 'required_if:sender.pickup,address',
            'sender.street_vh' => 'required_if:sender.pickup,address',
            'sender.office' => "required_if:sender.pickup,office|exists:$db.econt_offices,id",

            'receiver.name' => 'required',
            'receiver.phone' => 'required',
            'receiver.settlement' => "required|integer|exists:$db.econt_settlements,id",
            'receiver.pickup' => 'required|in:address,office',
            'receiver.street' => "required_if:receiver.pickup,address|exists:$db.econt_streets,id",
//            'receiver.street_num' => 'required_if:receiver.pickup,address',
//            'receiver.street_vh' => 'required_if:receiver.pickup,address',
            'receiver.office' => "required_if:receiver.pickup,office|exists:$db.econt_offices,id",

            'shipment.num' => 'required',
            'shipment.type' => 'required',
            'shipment.description' => 'required',
            'shipment.count' => 'required|integer|min:1',
            'shipment.weight' => 'required|numeric|min:0.001',
        ];

        if(Input::get('courier.date')) {
            $rules['courier.date'] = 'date_format:Y-m-d';
            $rules['courier.time_from'] = 'required_with:courier.date|date_format:H:i';
            $rules['courier.time_to'] = 'required_with:courier.date|date_format:H:i';
        }

        return $rules;
    }

}