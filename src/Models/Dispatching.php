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

    const DIRECTION_FROM = 'from_door';
    const DIRECTION_TO = 'to_door';

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

        foreach ($keys as $key) {
            if (!isset($data['attach_offices'][$key])) {
                continue;
            }

            $shipments = [
                self::SHIPMENT_COURIER => 'courier',
                self::SHIPMENT_CARGO_PALLET => 'cargo_pallet',
                self::SHIPMENT_CARGO_EXPRESS => 'cargo_express',
                self::SHIPMENT_POST => 'post',
            ];

            $shipment = $shipments[$key];

            if (isset($data['attach_offices'][$key])) {
                foreach ($data['attach_offices'][$key] as $dir => $codes) {
                    if (self::DIRECTION_FROM !== $dir && self::DIRECTION_TO !== $dir) {
                        throw new EcontException('Invalid direction.');
                    }

                    $directions = [
                        self::DIRECTION_FROM => 'from',
                        self::DIRECTION_TO => 'to',
                    ];

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
        $directions = ['from', 'to'];

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