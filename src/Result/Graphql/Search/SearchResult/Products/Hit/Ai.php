<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products\Hit;

use Nosto\Util\GraphQLUtils;
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
        $this->primaryColor = GraphQLUtils::getProperty($data, 'primaryColor');
        $this->overridingColor = GraphQLUtils::getProperty($data, 'overridingColor');
        $this->dominantColors = GraphQLUtils::getProperty($data, 'dominantColors');
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
