<?php
namespace Rolice\Econt\Models;

use Config;

use Illuminate\Database\Eloquent\Model;
use Rolice\Econt\Exceptions\EcontException;
use Rolice\Econt\ImportInterface;

class City extends Model implements ImportInterface
{

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
    protected $table = 'econt_cities';

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

        $keys = [
            'id',
            'post_code',
            'type',
            'id_zone',
            'name',
            'name_en',
            'region',
            'region_en',
            'id_country',
            'id_office',
            'updated_time',
            'hub_code',
            'hub_name',
            'hub_name_en',
            'service_days',
            'attach_offices',
        ];

        foreach ($keys as $key) {
            if (!isset($data[$key])) {
                return false;
            }
        }

        if (0 >= (int)$data['id'] || 0 >= (int)$data['id_country']) {
            return false;
        }

        return true;
    }

    public function import(array $data)
    {
        if (!$this->validateImport($data)) {
            return;
        }

        $this->id = (int)$data['id'];
        $this->post_code = $data['post_code'] ?: '';
        $this->type = $data['type'] ?: null;
        $this->zone_id = (int)$data['id_zone'] ?: null;
        $this->country_id = (int)$data['id_country'];
        $this->name = $data['name'] ?: '';
        $this->name_en = $data['name_en'] ?: '';
        $this->region = $data['region'] ?: '';
        $this->region_en = $data['region_en'] ?: '';
        $this->office_id = (int)$data['id_office'] ?: null;
        $this->updated_time = $data['updated_time'] && '0000-00-00 00:00:00' != $data['updated_time'] ? $data['updated_time'] : null;
        $this->hub_code = $data['hub_code'] ?: '';
        $this->hub_name = $data['hub_name'] ?: '';
        $this->hub_name_en = $data['hub_name_en'] ?: '';

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

        if (!$this->save()) {
            throw new EcontException("Error importing zone {$this->id} (named: {$this->name}).");
        }
    }

}