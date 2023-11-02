<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products\Hit;

use Nosto\Util\GraphQL;
use stdClass;

class Ai
{
    /** @var ?string */
    private $primaryColor;

    /** @var ?string */
    private $overridingColor;

    /** @var ?string[] */
    private $dominantColors;

    public function __construct(stdClass $data)
    {
        $this->primaryColor = GraphQL::getProperty($data, 'primaryColor');
        $this->overridingColor = GraphQL::getProperty($data, 'overridingColor');
        $this->dominantColors = GraphQL::getProperty($data, 'dominantColors');
    }

    /**
     * @return ?string
     */
    public function getPrimaryColor()
    {
        return $this->primaryColor;
    }

    /**
     * @return ?string
     */
    public function getOverridingColor()
    {
        return $this->overridingColor;
    }

    /**
     * @return ?string[]
     */
    public function getDominantColors()
    {
        return $this->dominantColors;
    }
}
