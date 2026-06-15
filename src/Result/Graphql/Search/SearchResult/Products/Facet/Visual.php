<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products\Facet;

use Nosto\Util\GraphQLUtils;
use stdClass;

class Visual
{
    /** @var ?string */
    private $type;

    /** @var ?string */
    private $value;

    public function __construct(stdClass $data)
    {
        $this->type = GraphQLUtils::getProperty($data, 'type');
        $this->value = GraphQLUtils::getProperty($data, 'value');
    }

    /**
     * @return ?string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return ?string
     */
    public function getValue()
    {
        return $this->value;
    }
}
