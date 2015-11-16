<?php
namespace Rolice\Econt\Models;

use Config;

use Illuminate\Database\Eloquent\Model;
use Rolice\Econt\Exceptions\EcontException;
use Rolice\Econt\ImportInterface;

class Office extends Model implements ImportInterface
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
    protected $table = 'econt_offices';

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

    public function city()
    {
        return $this->belongsTo('Rolice\Econt\Models\Settlement', 'city_id');
    }

    public function neighbourhood()
    {
        $this->belongsTo('Rolice\Econt\Models\Neighbourhood');
    }

    public function street()
    {
        $this->belongsTo('Rolice\Econt\Models\Street');
    }

    public function validateImport(array $data)
    {
        if (empty($data)) {
            return false;
        }

        $keys = [
            'id',
            'name',
            'name_en',
            'office_code',
            'address',
            'address_en',
            'id_city',
            'city_name',
            'city_name_en',
            'latitude',
            'longitude',
            'address_details',
            'phone',
            'work_begin',
            'work_end',
            'work_begin_saturday',
            'work_end_saturday',
            'time_priority',
            'updated_time',
        ];

        foreach ($keys as $key) {
            if (!isset($data[$key])) {
                return false;
            }
        }

        if (0 >= (int)$data['id'] || 0 >= (int)$data['id_city']) {
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
        $this->name = $data['name'] ?: '';
        $this->name_en = $data['name_en'] ?: '';
        $this->office_code = (int)$data['office_code'] ?: null;
        $this->address = $data['address'] ?: '';
        $this->address_en = $data['address_en'] ?: '';
        $this->city_id = (int)$data['id_city'];
        $this->city = $data['city_name'] ?: '';
        $this->city_en = $data['city_name_en'] ?: '';
        $this->neighbourhood_id = (int)$data['id_quarter'] ?: null;
        $this->neighbourhood = $data['quarter_name'] ?: null;
        $this->street_id = (int)$data['id_street'] ?: null;
        $this->street = $data['street_name'] ?: null;
        $this->street_num = $data['num'] ?: null;
        $this->bl = $data['bl'] ?: null;
        $this->vh = $data['vh'] ?: null;
        $this->et = $data['et'] ?: null;
        $this->ap = $data['ap'] ?: null;
        $this->other = $data['other'] ?: null;
        $this->phone = $data['phone'] ?: null;
        $this->work_begin = $data['work_begin'] && '00:00:00' != $data['work_begin'] ? $data['work_begin'] : null;
        $this->work_end = $data['work_end'] && '00:00:00' != $data['work_end'] ? $data['work_end'] : null;
        $this->work_begin_saturday = $data['work_begin_saturday'] && '00:00:00' != $data['work_begin_saturday'] ? $data['work_begin_saturday'] : null;
        $this->work_end_saturday = $data['work_end_saturday'] && '00:00:00' != $data['work_end_saturday'] ? $data['work_end_saturday'] : null;
        $this->priority = $data['time_priority'] && '00:00:00' != $data['time_priority'] ? $data['time_priority'] : null;
        $this->updated_time = $data['updated_time'] && '0000-00-00 00:00:00' != $data['updated_time'] ? $data['updated_time'] : null;

        if (!$this->save()) {
            throw new EcontException("Error importing office {$this->id}, named {$this->name} with type {$this->type}.");
        }
    }

}