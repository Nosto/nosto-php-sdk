<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products;

use Nosto\Util\GraphQLUtils;
use stdClass;

class StatsFacet extends Facet
{
    /** @var ?float */
    private $min;

    /** @var ?float */
    private $max;

    public function __construct(stdClass $data)
    {
        parent::__construct($data);

        $this->min = GraphQLUtils::getProperty($data, 'min');
        $this->max = GraphQLUtils::getProperty($data, 'max');
    }

    /**
     * @return ?float
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @return ?float
     */
    public function getMax()
    {
        return $this->max;
    }
}
