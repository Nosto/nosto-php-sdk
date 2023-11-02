<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products\Hit;

use Nosto\Util\GraphQL;
use stdClass;

class Sku
{
    /** @var ?string */
    private $id;

    /** @var ?string */
    private $name;

    /** @var ?float */
    private $price;

    /** @var ?float */
    private $listPrice;

    /** @var ?string */
    private $priceText;

    /** @var ?string */
    private $url;

    /** @var ?string */
    private $imageUrl;

    /** @var ?int */
    private $inventoryLevel;

    /** @var ?CustomField[] */
    private $customFields;

    /** @var ?string */
    private $availability;

    /** @var ?Ai */
    private $ai;

    public function __construct(stdClass $data)
    {
        $this->id = GraphQL::getProperty($data, 'id');
        $this->url = GraphQL::getProperty($data, 'url');
        $this->name = GraphQL::getProperty($data, 'name');
        $this->imageUrl = GraphQL::getProperty($data, 'imageUrl');
        $this->availability = GraphQL::getProperty($data, 'availability');
        $this->price = GraphQL::getProperty($data, 'price');
        $this->priceText = GraphQL::getProperty($data, 'priceText');
        $this->customFields = GraphQL::getArrayProperty($data, 'customFields', CustomField::class);
        $this->listPrice = GraphQL::getProperty($data, 'listPrice');
        $this->inventoryLevel = GraphQL::getProperty($data, 'inventoryLevel');
        $this->ai = GraphQL::getClassProperty($data, 'ai', Ai::class);
    }

    /**
     * @return ?string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ?string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return ?string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ?string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
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
     * @return ?string
     */
    public function getPriceText()
    {
        return $this->priceText;
    }

    /**
     * @return ?CustomField[]
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }

    /**
     * @return ?float
     */
    public function getListPrice()
    {
        return $this->listPrice;
    }

    /**
     * @return ?int
     */
    public function getInventoryLevel()
    {
        return $this->inventoryLevel;
    }

    /**
     * @return ?Ai
     */
    public function getAi()
    {
        return $this->ai;
    }
}
