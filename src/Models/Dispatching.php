<?php
namespace Rolice\Econt\Models;

use Config;

use Illuminate\Database\Eloquent\Model;
use Rolice\Econt\Exceptions\EcontException;
use Rolice\Econt\ImportInterface;

class Dispatching extends Model implements ImportInterface
{

    const ECONT_SHIPMENT_COURIER = 'courier_shipments';
    const ECONT_SHIPMENT_CARGO_PALLET = 'cargo_palet_shipments';
    const ECONT_SHIPMENT_CARGO_EXPRESS = 'cargo_expres_shipments';
    const ECONT_SHIPMENT_POST = 'post_shipments';

    const ECONT_DIRECTION_FROM_DOOR = 'from_door';
    const ECONT_DIRECTION_TO_DOOR = 'to_door';
    const ECONT_DIRECTION_FROM_OFFICE = 'from_office';
    const ECONT_DIRECTION_TO_OFFICE = 'to_office';

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

    public function settlement() {
        return $this->belongsTo('Rolice\Econt\Models\Settlement');
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

        if (0 >= (int)$data['id'] || 0 >= count($data['attach_offices'])) {
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

        $shipments = [
            self::ECONT_SHIPMENT_COURIER => 'courier',
            self::ECONT_SHIPMENT_CARGO_PALLET => 'cargo_pallet',
            self::ECONT_SHIPMENT_CARGO_EXPRESS => 'cargo_express',
            self::ECONT_SHIPMENT_POST => 'post',
        ];

        $directions = [
            self::ECONT_DIRECTION_FROM_DOOR => self::ECONT_DIRECTION_FROM_DOOR,
            self::ECONT_DIRECTION_TO_DOOR => self::ECONT_DIRECTION_TO_DOOR,
            self::ECONT_DIRECTION_FROM_OFFICE => self::ECONT_DIRECTION_FROM_OFFICE,
            self::ECONT_DIRECTION_TO_OFFICE => self::ECONT_DIRECTION_TO_OFFICE,
        ];

        foreach ($keys as $key) {
            if (!isset($data['attach_offices'][$key])) {
                continue;
            }

            $shipment = $shipments[$key];

            if (isset($data['attach_offices'][$key])) {
                foreach ($data['attach_offices'][$key] as $dir => $codes) {
                    if (!in_array($dir, $directions)) {
                        throw new EcontException("Invalid direction $dir.");
                    }

                    $direction = $directions[$dir];

                    if (is_scalar($codes) && (int)$codes) {
                        self::_import($data['id'], $shipment, $direction, $codes);
                        continue;
                    }

                    if (is_array($codes)) {
                        foreach ($codes as $code) {
                            self::_import($data['id'], $shipment, $direction, $code);
                            continue;
                        }
                    }
                }
            }
        }
    }

    private static function _import($settlement_id, $shipment, $direction, $code)
    {
        $shipments = ['courier', 'cargo_pallet', 'cargo_express', 'post'];
        $directions = ['from_door', 'to_door', 'from_office', 'to_office'];

        if (!in_array((string)$shipment, $shipments) || !in_array((string)$direction, $directions)) {
            throw new EcontException("Invalid dispatching data. Shipment is $shipment and direction is $direction.");
        }

        $dispatching = new self;

        $dispatching->settlement_id = (int)$settlement_id;
        $dispatching->shipment = $shipment;
        $dispatching->direction = $direction;
        $dispatching->office_code = (int)$code;

        if (!$dispatching->save()) {
            throw new EcontException('Could not import dispatching data.');
        }
    }
}