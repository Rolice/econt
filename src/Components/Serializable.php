<?php
namespace Rolice\Econt\Components;

use ReflectionClass;
use Rolice\Econt\Exceptions\EcontException;
use SimpleXMLElement;
use Rolice\Econt\Components\ComponentInterface;

/**
 * Class Serializable
 * Trait providing, common, basic, uni-purpose serialization of ComponentInterface object to XML
 * @package Rolice\Econt\Components
 * @verion 1.0
 */
trait Serializable
{

    /**
     * Default implementation of ComponentInterface::tag. Returns current class name (w/o namespace).
     * @return string
     */
    public function tag()
    {
        return (new ReflectionClass($this))->getShortName();
    }

    /**
     * Serializes an object for subsequent XML communication.
     * @return SimpleXMLElement
     */
    public function serialize()
    {
        $result = new SimpleXMLElement("<{$this->tag()}/>");
        $this->build($result, $this);

        return $result;
    }

    public function toArray()
    {
        $result = [];
        $this->buildArray($result, $this);

        return $result;
    }

    /**
     * Builds an Econt-compatible XML request
     * @param SimpleXMLElement $xml Currently scoped XML representation object.
     * @param ComponentInterface|array $data A user-defined, custom request structure for the XML file.
     */
    protected function build(SimpleXMLElement $xml, $data)
    {
        if (!is_object($data) && !is_array($data)) {
            throw new EcontException('Invalid entity for serialization. An implementation of ComponentInterface or array required.');
        }

        if (is_object($data) && !($data instanceof ComponentInterface)) {
            throw new EcontException('An object given is not an implementation of class ComponentInterface.');
        }

        $reflected = !is_array($data);
        $iterator = $reflected ? (new ReflectionClass($data))->getProperties() : $data;

        foreach ($iterator as $key => $value) {
            if ($reflected) {
                if (0 === strpos($value->getName(), '_')) {
                    continue;
                }

                $value->setAccessible(true);
            }

            $key = $reflected ? $value->getName() : $key;
            $value = $reflected ? $value->getValue($data) : $value;

            if (null !== $value && !is_scalar($value)) {
                if (is_object($value) && !($value instanceof ComponentInterface)) {
                    continue;
                }

                $nested = $xml->addChild($key);
                $this->build($nested, $value);
                continue;
            }

            $xml->addChild($key, $value);
        }
    }

    protected function buildArray(array &$array, $data)
    {
        if (!is_object($data) && !is_array($data)) {
            throw new EcontException('Invalid entity for serialization. An implementation of ComponentInterface or array required.');
        }

        if (is_object($data) && !($data instanceof ComponentInterface)) {
            throw new EcontException('An object given is not an implementation of class ComponentInterface.');
        }

        $reflected = !is_array($data);
        $iterator = $reflected ? (new ReflectionClass($data))->getProperties() : $data;

        foreach ($iterator as $key => $value) {
            if ($reflected) {
                if (0 === strpos($value->getName(), '_')) {
                    continue;
                }

                $value->setAccessible(true);
            }

            $key = $reflected ? $value->getName() : $key;
            $value = $reflected ? $value->getValue($data) : $value;

            if (null !== $value && !is_scalar($value)) {
                if (is_object($value) && !($value instanceof ComponentInterface)) {
                    continue;
                }

                $nested = [];
                $this->buildArray($nested, $value);
                $array[$key] = $nested;
                continue;
            }

            $array[$key] = $value;
        }
    }

}