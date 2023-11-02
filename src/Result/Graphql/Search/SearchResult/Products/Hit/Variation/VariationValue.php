<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products\Hit\Variation;

use Nosto\Util\GraphQL;
use stdClass;

class VariationValue
{
    /** @var ?string */
    private $availability;

    /** @var ?float */
    private $price;

    /** @var ?float */
    private $listPrice;

    /** @var ?string */
    private $priceCurrencyCode;

    public function __construct(stdClass $data)
    {
        $this->availability = GraphQL::getProperty($data, 'availability');
        $this->price = GraphQL::getProperty($data, 'price');
        $this->listPrice = GraphQL::getProperty($data, 'listPrice');
        $this->priceCurrencyCode = GraphQL::getProperty($data, 'priceCurrencyCode');
    }

    /**
     * @return ?string
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @return ?float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return ?float
     */
    public function getListPrice()
    {
        return $this->listPrice;
    }

    /**
     * @return ?string
     */
    public function getPriceCurrencyCode()
    {
        return $this->priceCurrencyCode;
    }
}