<?php
namespace Rolice\Econt\Components;

use DateTime;
use Rolice\Econt\Exceptions\EcontException;

/**
 * Class CourierRequest
 * Class representing courier request segment of loading request
 * @package Rolice\Econt\Component
 * @version 1.0
 * @access public
 */
class CourierRequest implements ComponentInterface
{

    use Serializable;

    /**
     * An instance containing the related shipment information
     * @var Shipment
     */
    protected $_shipment = null;

    /**
     * Whether to create request without shipment
     * @var bool
     */
    protected $only_courier_request = false;

    /**
     * Desired start date-time for courier arrival interval
     * @var DateTime
     */
    protected $_from = null;

    /**
     * Desired end date-time for courier arrival interval
     * @var DateTime
     */
    protected $_to = null;

    /**
     * Desired start date-time for courier arrival interval
     * @var DateTime
     */
    protected $time_from = null;

    /**
     * Desired end date-time for courier arrival interval
     * @var DateTime
     */
    protected $time_to = null;

    public function __construct(Shipment &$shipment, DateTime $from, DateTime $to, $only_courier_request = false)
    {
        if (!$shipment) {
            throw new EcontException('A valid reference to related shipment is required when creating courier request.');
        }

        if (!$from || !$to) {
            throw new EcontException('Please supply valid date-time for the courier request.');
        }

        if ($from->format('Y-m-d') !== $to->format('Y-m-d')) {
            throw new EcontException('Courier request can be made for a single day. Only time from/to may differ.');
        }

        $this->_from = $from;
        $this->_to = $to;

        $this->time_from = $from->format('H:i');
        $this->time_to = $to->format('H:i');

        $this->only_courier_request = !!$only_courier_request;

        $this->_shipment = $shipment;
        $this->_shipment->send_date = $from->format('Y-m-d');
    }

    public function tag()
    {
        return 'courier_request';
    }

}