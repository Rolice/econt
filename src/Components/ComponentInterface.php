<?php
namespace Rolice\Econt\Components;

use SimpleXMLElement;

/**
 * Interface ComponentInterface
 * Defines serialization mechanisms for communication with Econt end-points
 * @package Rolice\Econt\Components
 * @version 1.0
 */
interface ComponentInterface {

    /**
     * Serializes the current instance into SimpleXMLElement
     * @return SimpleXMLElement
     */
    public function serialize();

}
