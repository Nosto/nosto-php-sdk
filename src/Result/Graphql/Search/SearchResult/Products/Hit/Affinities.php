<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products\Hit;

use Nosto\Util\GraphQL;
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
        $this->brand = GraphQL::getProperty($data, 'brand');
        $this->categories = GraphQL::getProperty($data, 'categories');
        $this->color = GraphQL::getProperty($data, 'color');
        $this->size = GraphQL::getProperty($data, 'size');
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
