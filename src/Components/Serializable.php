<?php
namespace Rolice\Econt\Components;

use SimpleXMLElement;

trait Serializable
{
    protected $serializationRootElement = null;

    /**
     * Serializes an object for subsequent XML communication.
     * @return SimpleXMLElement
     */
    public function serialize()
    {
        $result = new SimpleXMLElement($this->serializationRootElement ? "<{$this->serializationRootElement}/>" : null);
        $this->build($result, (array) $this);

        return $result;
    }

    /**
     * Builds an Econt-compatible XML request
     * @param SimpleXMLElement $xml Currently scoped XML representation object.
     * @param array $data A user-defined, custom request structure for the XML file.
     */
    protected function build(SimpleXMLElement $xml, array $data)
    {
        foreach ($data as $key => $value) {
            if (!is_scalar($value)) {
                $nested = $xml->addChild($key);
                $this->build($nested, $value);
                continue;
            }

            $xml->addChild($key, $value);
        }
    }

}