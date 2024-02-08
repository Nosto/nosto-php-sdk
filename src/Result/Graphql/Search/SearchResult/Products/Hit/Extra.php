<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products\Hit;

use Nosto\Util\GraphQLUtils;
use stdClass;

class Extra
{
    /** @var ?string */
    private $key;

    /** @var ?string[] */
    private $value;

    public function __construct(stdClass $data)
    {
        $this->key = GraphQLUtils::getProperty($data, 'key');
        $this->value = GraphQLUtils::getProperty($data, 'value');
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
