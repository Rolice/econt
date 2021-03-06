<?php
namespace Rolice\Econt\Models;

use App;
use Config;
use Illuminate\Database\Eloquent\Model;
use Lang;
use Rolice\Econt\Exceptions\EcontException;
use Rolice\Econt\ImportInterface;

class Settlement extends Model implements ImportInterface
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
    protected $table = 'econt_settlements';

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
    protected $appends = ['formatted', 'reference'];

    public function __construct($attributes = [])
    {
        parent::__construct($attributes);
        $this->setConnection(Config::get('econt.connection'));
    }

    public function country()
    {
        return $this->belongsTo('Rolice\Econt\Models\Settlement', 'country_id');
    }

    public function neighbourhoods()
    {
        return $this->hasMany('Rolice\Econt\Models\Neighbourhoods', 'city_id');
    }

    public function dispatching()
    {
        $this->hasMany('Rolice\Econt\Models\Dispatching');
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

        $type = null;

        if (isset($data['type'])) {
            switch ($data['type']) {
                case 'гр.':
                    $type = 'city';
                    break;

                case 'с.':
                    $type = 'village';
                    break;
            }
        }

        $service_days = '';

        for ($i = 1; $i <= 7; $i++) {
            $service_days = (isset($data['service_days']["day$i"]) ? (int)!!$data['service_days']["day$i"] : 0) . $service_days;
        }

        $service_days = 0 . $service_days;

        $this->id = (int)$data['id'];
        $this->post_code = (int)$data['post_code'] ?: null;
        $this->type = $type;
        $this->zone_id = (int)$data['id_zone'] ?: null;
        $this->country_id = (int)$data['id_country'] ?: null;
        $this->name = $data['name'] ?: '';
        $this->name_en = $data['name_en'] ?: '';
        $this->region = $data['region'] ?: '';
        $this->region_en = $data['region_en'] ?: '';
        $this->office_id = (int)$data['id_office'] ?: null;
        $this->updated_time = $data['updated_time'] && '0000-00-00 00:00:00' != $data['updated_time'] ? $data['updated_time'] : null;
        $this->hub_code = $data['hub_code'] ?: '';
        $this->hub_name = $data['hub_name'] ?: '';
        $this->hub_name_en = $data['hub_name_en'] ?: '';
        $this->service_days = bindec($service_days);

        (new Dispatching)->import($data);

        if (!$this->save()) {
            throw new EcontException("Error importing settlement {$this->id}, named {$this->name} with type {$this->type}.");
        }
    }

    public function getFormattedAttribute()
    {
        return Lang::get('econt::econt.settlement.type.' . $this->type)
        . " {$this->{'bg' == App::getLocale() ? 'name' : 'name_en'}} ({$this->post_code})";
    }

    public function getReferenceAttribute()
    {
        return $this->{'bg' == App::getLocale() ? 'name' : 'name_en'};
    }

}