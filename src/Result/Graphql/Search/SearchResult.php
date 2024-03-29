<?php

namespace Nosto\Result\Graphql\Search;

use Nosto\Result\Graphql\Search\SearchResult\Explain;
use Nosto\Result\Graphql\Search\SearchResult\Products;
use Nosto\Util\GraphQLUtils;
use stdClass;

class SearchResult
{
    /** @var ?string */
    private $redirect;

    /** @var ?string */
    private $query;

    /** @var ?Explain */
    private $explain;

    /** @var ?Products */
    private $products;

    public function __construct(stdClass $data)
    {
        $this->redirect = GraphQLUtils::getProperty($data, 'redirect');
        $this->query = GraphQLUtils::getProperty($data, 'query');
        $this->explain = GraphQLUtils::getClassProperty($data, 'explain', Explain::class);
        $this->products = GraphQLUtils::getClassProperty($data, 'products', Products::class);
    }

    /**
     * @return ?string
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * @return ?string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return ?Explain
     */
    public function getExplain()
    {
        return $this->explain;
    }

    /**
     * @return ?Products
     */
    public function getProducts()
    {
        return $this->products;
    }
}
