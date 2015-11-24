<?php
namespace Rolice\Econt\Http\Requests;

use Config;
use App\Http\Requests\Request;

class CalculateRequest extends Request {

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

        return [
            'sender.settlement' => "required|integer|exists:$db.econt_settlements,id",
            'sender.pickup' => 'required|in:address,office',
            'sender.office' => "required_if:sender.pickup,office|exists:$db.econt_offices,id",

            'receiver.settlement' => "required|integer|exists:$db.econt_settlements,id",
            'receiver.pickup' => 'required|in:address,office',
            'receiver.office' => "required_if:receiver.pickup,office|exists:$db.econt_offices,id",

            'shipment.num' => 'required',
            'shipment.type' => 'required',
            'shipment.description' => 'required',
            'shipment.count' => 'required|integer|min:1',
            'shipment.weight' => 'required|numeric|min:0.001',
        ];
    }

}