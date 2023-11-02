<?php

namespace Nosto\Result\Graphql\Search\SearchResult;

use Nosto\Result\Graphql\Search\SearchResult\Products\Facet;
use Nosto\Result\Graphql\Search\SearchResult\Products\Hit;
use Nosto\Util\GraphQL;
use stdClass;

class Products
{
    /** @var ?int */
    private $total;

    /** @var ?int */
    private $size;

    /** @var ?int */
    private $from;

    /** @var ?string */
    private $collapse;

    /** @var ?boolean */
    private $fuzzy;

    /** @var ?string */
    private $categoryId;

    /** @var ?string */
    private $categoryPath;

    /** @var ?Hit[] */
    private $hits;

    /** @var ?Facet[] */
    private $facets;

    public function __construct(stdClass $data)
    {
        $this->total = GraphQL::getProperty($data, 'total');
        $this->size = GraphQL::getProperty($data, 'size');
        $this->from = GraphQL::getProperty($data, 'from');
        $this->collapse = GraphQL::getProperty($data, 'collapse');
        $this->fuzzy = GraphQL::getProperty($data, 'fuzzy');
        $this->categoryId = GraphQL::getProperty($data, 'categoryId');
        $this->categoryPath = GraphQL::getProperty($data, 'categoryPath');
        $this->hits = GraphQL::getArrayProperty($data, 'hits', Hit::class);
        $this->facets = property_exists($data, 'facets') && $data->facets
            ? array_map(
                function (stdClass $facet) {
                    return Facet::getInstance($facet);
                },
                $data->facets
            )
            : null;
    }

    /**
     * @return ?int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @return ?int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return ?int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return ?string
     */
    public function getCollapse()
    {
        return $this->collapse;
    }

    /**
     * @return ?bool
     */
    public function getFuzzy()
    {
        return $this->fuzzy;
    }

    /**
     * @return ?string
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @return ?string
     */
    public function getCategoryPath()
    {
        return $this->categoryPath;
    }

    /**
     * @return ?Hit[]
     */
    public function getHits()
    {
        return $this->hits;
    }

    /**
     * @return ?Facet[]
     */
    public function getFacets()
    {
        return $this->facets;
    }
}