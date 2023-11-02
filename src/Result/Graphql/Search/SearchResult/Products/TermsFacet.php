<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products;

use Nosto\Result\Graphql\Search\SearchResult\Products\Facet\TermsFacetValue;
use Nosto\Util\GraphQL;
use stdClass;

class TermsFacet extends Facet
{
    /** @var TermsFacetValue[] */
    private $data;

    public function __construct(stdClass $data)
    {
        parent::__construct($data);

        $this->data = GraphQL::getArrayProperty($data, 'data', TermsFacetValue::class);
    }

    /**
     * @return ?TermsFacetValue[]
     */
    public function getData()
    {
        return $this->data;
    }
}
