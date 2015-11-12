<?php
namespace CloudCart\Econt\Component;

use ReflectionClass;

trait Serializable
{
    /**
     * Serializes an object as an array for subsequent XML serialization.
     */
    public function serialize()
    {
        return (array) $this;
    }

}