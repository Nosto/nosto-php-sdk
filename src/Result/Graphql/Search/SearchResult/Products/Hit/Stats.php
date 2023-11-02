<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products\Hit;

use Nosto\Util\GraphQL;
use stdClass;

class Stats
{
    /** @var ?float */
    private $price;

    /** @var ?float */
    private $listPrice;

    /** @var ?float */
    private $discount;

    /** @var ?float */
    private $ratingValue;

    /** @var ?float */
    private $reviewCount;

    /** @var ?float */
    private $margin;

    /** @var ?float */
    private $marginPercentage;

    /** @var ?float */
    private $inventoryLevel;

    /** @var ?float */
    private $age;

    /** @var ?float */
    private $published;

    /** @var ?float */
    private $impressions;

    /** @var ?float */
    private $views;

    /** @var ?float */
    private $clicks;

    /** @var ?float */
    private $buys;

    /** @var ?float */
    private $orders;

    /** @var ?float */
    private $conversion;

    /** @var ?float */
    private $cartRatio;

    /** @var ?float */
    private $revenue;

    /** @var ?float */
    private $revenuePerImpression;

    /** @var ?float */
    private $revenuePerView;

    /** @var ?float */
    private $profitPerImpression;

    /** @var ?float */
    private $profitPerView;

    /** @var ?float */
    private $inventoryTurnover;

    /** @var ?float */
    private $availabilityRatio;

    public function __construct(stdClass $data)
    {
        $this->price = GraphQL::getProperty($data, 'price');
        $this->listPrice = GraphQL::getProperty($data, 'listPrice');
        $this->discount = GraphQL::getProperty($data, 'discount');
        $this->ratingValue = GraphQL::getProperty($data, 'ratingValue');
        $this->reviewCount = GraphQL::getProperty($data, 'reviewCount');
        $this->margin = GraphQL::getProperty($data, 'margin');
        $this->marginPercentage = GraphQL::getProperty($data, 'marginPercentage');
        $this->inventoryLevel = GraphQL::getProperty($data, 'inventoryLevel');
        $this->age = GraphQL::getProperty($data, 'age');
        $this->published = GraphQL::getProperty($data, 'published');
        $this->impressions = GraphQL::getProperty($data, 'impressions');
        $this->views = GraphQL::getProperty($data, 'views');
        $this->clicks = GraphQL::getProperty($data, 'clicks');
        $this->buys = GraphQL::getProperty($data, 'buys');
        $this->orders = GraphQL::getProperty($data, 'orders');
        $this->conversion = GraphQL::getProperty($data, 'conversion');
        $this->cartRatio = GraphQL::getProperty($data, 'cartRatio');
        $this->revenue = GraphQL::getProperty($data, 'revenue');
        $this->revenuePerImpression = GraphQL::getProperty($data, 'revenuePerImpression');
        $this->revenuePerView = GraphQL::getProperty($data, 'revenuePerView');
        $this->profitPerImpression = GraphQL::getProperty($data, 'profitPerImpression');
        $this->profitPerView = GraphQL::getProperty($data, 'profitPerView');
        $this->inventoryTurnover = GraphQL::getProperty($data, 'inventoryTurnover');
        $this->availabilityRatio = GraphQL::getProperty($data, 'availabilityRatio');
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
     * @return ?float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @return ?float
     */
    public function getRatingValue()
    {
        return $this->ratingValue;
    }

    /**
     * @return ?float
     */
    public function getReviewCount()
    {
        return $this->reviewCount;
    }

    /**
     * @return ?float
     */
    public function getMargin()
    {
        return $this->margin;
    }

    /**
     * @return ?float
     */
    public function getMarginPercentage()
    {
        return $this->marginPercentage;
    }

    /**
     * @return ?float
     */
    public function getInventoryLevel()
    {
        return $this->inventoryLevel;
    }

    /**
     * @return ?float
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @return ?float
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @return ?float
     */
    public function getImpressions()
    {
        return $this->impressions;
    }

    /**
     * @return ?float
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @return ?float
     */
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * @return ?float
     */
    public function getBuys()
    {
        return $this->buys;
    }

    /**
     * @return ?float
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @return ?float
     */
    public function getConversion()
    {
        return $this->conversion;
    }

    /**
     * @return ?float
     */
    public function getCartRatio()
    {
        return $this->cartRatio;
    }

    /**
     * @return ?float
     */
    public function getRevenue()
    {
        return $this->revenue;
    }

    /**
     * @return ?float
     */
    public function getRevenuePerImpression()
    {
        return $this->revenuePerImpression;
    }

    /**
     * @return ?float
     */
    public function getRevenuePerView()
    {
        return $this->revenuePerView;
    }

    /**
     * @return ?float
     */
    public function getProfitPerImpression()
    {
        return $this->profitPerImpression;
    }

    /**
     * @return ?float
     */
    public function getProfitPerView()
    {
        return $this->profitPerView;
    }

    /**
     * @return ?float
     */
    public function getInventoryTurnover()
    {
        return $this->inventoryTurnover;
    }

    /**
     * @return ?float
     */
    public function getAvailabilityRatio()
    {
        return $this->availabilityRatio;
    }

}