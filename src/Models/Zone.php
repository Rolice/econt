<?php
namespace Rolice\Econt\Models;

use Config;

use Illuminate\Database\Eloquent\Model;
use Rolice\Econt\ImportInterface;

class Zone extends Model implements ImportInterface
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
    protected $table = 'econt_zones';

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
    protected $fillable = [];

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

    public function __construct()
    {
        $this->setConnection(Config::get('econt.connection'));
    }

    public function import(array $data)
    {
        $this->fill($data);
        dd($this);
    }
}