<?php
namespace Rolice\Econt\Models;

use Config;

use Illuminate\Database\Eloquent\Model;
use Rolice\Econt\Exceptions\EcontException;
use Rolice\Econt\ImportInterface;

class Dispatching extends Model implements ImportInterface
{

    const SHIPMENT_COURIER = 'courier_shipments';
    const SHIPMENT_CARGO_PALLET = 'cargo_palet_shipments';
    const SHIPMENT_CARGO_EXPRESS = 'cargo_expres_shipments';
    const SHIPMENT_POST = 'post_shipments';


    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = null;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'econt_dispatching';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['*'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Attributes dynamically-appended to the model
     * @var array
     */
    protected $appends = [];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->setConnection(Config::get('econt.connection'));
    }

    public function validateImport(array $data)
    {
        if (empty($data)) {
            return false;
        }

        $keys = ['attach_offices'];

        foreach ($keys as $key) {
            if (!isset($data[$key])) {
                return false;
            }
        }

        if (0 >= count($data['attach_offices'])) {
            return false;
        }

        return true;
    }

    public function import(array $data)
    {
        if (!$this->validateImport($data)) {
            return;
        }

        if (!isset($data['attach_offices'])) {
            return;
        }

        $keys = ['courier_shipments', 'cargo_palet_shipments', 'cargo_expres_shipments', 'post_shipments'];

        foreach ($keys as $key) {
            if (!isset($data['attach_offices'][$key])) {
                continue;
            }

            $types = [
                'courier_shipments' => 'courier',
                'cargo_palet_shipments' => 'cargo_pallet',
                'cargo_expres_shipments' => 'cargo_express',
                'post_shipments' => 'post',
            ];

            $type = $types[$key];

            if (isset($data['attach_offices'][$key]['from_door'])) {
                $direction = 'from';
            }
        }

        $dispatching = $data['attach_offices']['courier_shipments']['from_door']['office_code'];

        if (isset($data['attach_offices']['courier_shipments']['from_door']['office_code'])) {
            $dispatching = $data['attach_offices']['courier_shipments']['from_door']['office_code'];

        }


        $this->courier_from_door = isset($data['attach_offices']['courier_shipments']['from_door']['office_code']) ? $data['attach_offices']['courier_shipments']['from_door']['office_code'] : null;
        $this->courier_to_door = isset($data['attach_offices']['courier_shipments']['to_door']['office_code']) ? $data['attach_offices']['courier_shipments']['to_door']['office_code'] : null;
        $this->courier_from_office = isset($data['attach_offices']['courier_shipments']['from_office']['office_code']) ? $data['attach_offices']['courier_shipments']['from_office']['office_code'] : null;
        $this->courier_to_office = isset($data['attach_offices']['courier_shipments']['to_office']['office_code']) ? $data['attach_offices']['courier_shipments']['to_office']['office_code'] : null;

        $this->cargo_pallet_from_door = isset($data['attach_offices']['cargo_palet_shipments']['from_door']['office_code']) ? $data['attach_offices']['cargo_palet_shipments']['from_door']['office_code'] : null;
        $this->cargo_pallet_to_door = isset($data['attach_offices']['cargo_palet_shipments']['to_door']['office_code']) ? $data['attach_offices']['cargo_palet_shipments']['to_door']['office_code'] : null;
        $this->cargo_pallet_from_office = isset($data['attach_offices']['cargo_palet_shipments']['from_office']['office_code']) ? $data['attach_offices']['cargo_palet_shipments']['from_office']['office_code'] : null;
        $this->cargo_pallet_to_office = isset($data['attach_offices']['cargo_palet_shipments']['to_office']['office_code']) ? $data['attach_offices']['cargo_palet_shipments']['to_office']['office_code'] : null;

        $this->cargo_express_from_door = isset($data['attach_offices']['cargo_expres_shipments']['from_door']['office_code']) ? $data['attach_offices']['cargo_expres_shipments']['from_door']['office_code'] : null;
        $this->cargo_express_to_door = isset($data['attach_offices']['cargo_expres_shipments']['to_door']['office_code']) ? $data['attach_offices']['cargo_expres_shipments']['to_door']['office_code'] : null;
        $this->cargo_express_from_office = isset($data['attach_offices']['cargo_expres_shipments']['from_office']['office_code']) ? $data['attach_offices']['cargo_expres_shipments']['from_office']['office_code'] : null;
        $this->cargo_express_to_office = isset($data['attach_offices']['cargo_expres_shipments']['to_office']['office_code']) ? $data['attach_offices']['cargo_expres_shipments']['to_office']['office_code'] : null;

        $this->post_from_door = isset($data['attach_offices']['post_shipments']['from_door']['office_code']) ? $data['attach_offices']['post_shipments']['from_door']['office_code'] : null;
        $this->post_to_door = isset($data['attach_offices']['post_shipments']['to_door']['office_code']) ? $data['attach_offices']['post_shipments']['to_door']['office_code'] : null;
        $this->post_from_office = isset($data['attach_offices']['post_shipments']['from_office']['office_code']) ? $data['attach_offices']['post_shipments']['from_office']['office_code'] : null;
        $this->post_to_office = isset($data['attach_offices']['post_shipments']['to_office']['office_code']) ? $data['attach_offices']['post_shipments']['to_office']['office_code'] : null;
    }

}