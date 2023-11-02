<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products\Facet;

use Nosto\Util\GraphQL;
use stdClass;

class TermsFacetValue
{
    /** @var ?string */
    private $value;

    /** @var ?int */
    private $count;

    /** @var ?bool */
    private $selected;

    public function __construct(stdClass $data)
    {
        $this->value = GraphQL::getProperty($data, 'value');
        $this->count = GraphQL::getProperty($data, 'count');
        $this->selected = GraphQL::getProperty($data, 'selected');
    }

    /**
     * @return ?string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return ?int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @return ?bool
     */
    public function getSelected()
    {
        return $this->selected;
    }
}