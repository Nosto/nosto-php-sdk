<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products\Facet;

use Nosto\Util\GraphQLUtils;
use stdClass;

class TermsFacetValue
{
    /** @var ?string */
    private $value;

    /** @var ?int */
    private $count;

    /** @var ?bool */
    private $selected;

    /** @var ?Visual */
    private $visual;

    public function __construct(stdClass $data)
    {
        $this->value = GraphQLUtils::getProperty($data, 'value');
        $this->count = GraphQLUtils::getProperty($data, 'count');
        $this->selected = GraphQLUtils::getProperty($data, 'selected');
        $this->visual = GraphQLUtils::getClassProperty($data, 'visual', Visual::class);
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

    /**
     * @return ?Visual
     */
    public function getVisual()
    {
        return $this->visual;
    }
}
