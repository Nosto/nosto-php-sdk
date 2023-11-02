<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products\Hit;

use Nosto\Result\Graphql\Search\SearchResult\Products\Hit\Variation\VariationValue;
use Nosto\Util\GraphQL;
use stdClass;

class Variation
{
    /** @var ?string */
    private $key;

    /** @var ?VariationValue */
    private $value;

    public function __construct(stdClass $data)
    {
        $this->key = GraphQL::getProperty($data, 'key');
        $this->value = GraphQL::getClassProperty($data, 'value', VariationValue::class);
    }

    /**
     * @return ?string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return ?VariationValue
     */
    public function getValue()
    {
        return $this->value;
    }
}
