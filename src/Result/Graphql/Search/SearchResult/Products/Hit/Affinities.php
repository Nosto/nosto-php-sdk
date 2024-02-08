<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products\Hit;

use Nosto\Util\GraphQLUtils;
use stdClass;

class Affinities
{
    /** @var ?string */
    private $brand;

    /** @var ?string[] */
    private $categories;

    /** @var ?string[] */
    private $color;

    /** @var ?string[] */
    private $size;

    public function __construct(stdClass $data)
    {
        $this->brand = GraphQLUtils::getProperty($data, 'brand');
        $this->categories = GraphQLUtils::getProperty($data, 'categories');
        $this->color = GraphQLUtils::getProperty($data, 'color');
        $this->size = GraphQLUtils::getProperty($data, 'size');
    }

    /**
     * @return ?string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @return ?string[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @return ?string[]
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return ?string[]
     */
    public function getSize()
    {
        return $this->size;
    }
}
