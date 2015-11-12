<?php
namespace Rolice\Econt\Components;

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