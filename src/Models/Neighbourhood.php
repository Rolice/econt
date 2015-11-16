<?php
namespace Rolice\Econt\Models;

use Config;

use Illuminate\Database\Eloquent\Model;
use Rolice\Econt\Exceptions\EcontException;
use Rolice\Econt\ImportInterface;

class Neighbourhood extends Model implements ImportInterface
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
    protected $table = 'econt_neighbourhoods';

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

    public function validateImport(array $data)
    {
        if (empty($data)) {
            return false;
        }

        $keys = [
            'id',
            'name',
            'name_en',
            'city_post_code',
            'id_city',
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
        $this->city_post_code = (int) $data['city_post_code'] ?: '';
        $this->city_id = (int) $data['id_cty'];
        $this->updated_time = $data['updated_time'] && '0000-00-00 00:00:00' != $data['updated_time'] ? $data['updated_time'] : null;

        if (!$this->save()) {
            throw new EcontException("Error importing neighbourhood {$this->id}, named {$this->name}.");
        }
    }

}