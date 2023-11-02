<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products\Hit;

use Nosto\Util\GraphQL;
use stdClass;

class Extra
{
    /** @var ?string */
    private $key;

    /** @var ?string[] */
    private $value;

    public function __construct(stdClass $data)
    {
        $this->key = GraphQL::getProperty($data, 'key');
        $this->value = GraphQL::getProperty($data, 'value');
    }

    /**
     * @return ?string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return ?string[]
     */
    public function getValue()
    {
        return $this->value;
    }
}
