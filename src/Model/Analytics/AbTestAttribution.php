<?php

namespace Nosto\Model\Analytics;

class AbTestAttribution implements \JsonSerializable
{
    /**
     * @type string | null
     */
    private $key;
    /**
     * @type string | null
     */
    private $value;

    public function __construct(
        $key = null,
        $value = null
    )
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}

