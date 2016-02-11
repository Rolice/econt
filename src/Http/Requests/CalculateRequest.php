<?php
namespace Rolice\Econt\Http\Requests;

use Lang;
use Config;
use App\Http\Requests\Request;

class CalculateRequest extends Request
{

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
            'receiver.settlement' => "required|min:2",
            'receiver.pickup' => 'required|in:address,office',
            'receiver.office' => "required_if:receiver.pickup,office|exists:$db.econt_offices,id",
            'shipment.type' => 'required',
            'shipment.count' => 'required|integer|min:1',
            'shipment.weight' => 'required|numeric|min:0.001',
        ];
    }

    public function attributes()
    {
        $fields = [
            'sender.settlement',
            'sender.pickup',
            'sender.office',
            'receiver.settlement',
            'receiver.pickup',
            'receiver.office',
            'shipment.type',
            'shipment.count',
            'shipment.weight',
        ];

        $result = [];

        foreach($fields as $field)
        {
            $result[$field] = Lang::get("econt.attributes.$field");
        }

        return $result;
    }

}