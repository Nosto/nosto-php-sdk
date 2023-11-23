<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products\Hit;

use Nosto\Util\GraphQLUtils;
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
        $this->id = GraphQLUtils::getProperty($data, 'id');
        $this->url = GraphQLUtils::getProperty($data, 'url');
        $this->name = GraphQLUtils::getProperty($data, 'name');
        $this->imageUrl = GraphQLUtils::getProperty($data, 'imageUrl');
        $this->availability = GraphQLUtils::getProperty($data, 'availability');
        $this->price = GraphQLUtils::getProperty($data, 'price');
        $this->priceText = GraphQLUtils::getProperty($data, 'priceText');
        $this->customFields = GraphQLUtils::getArrayProperty($data, 'customFields', CustomField::class);
        $this->listPrice = GraphQLUtils::getProperty($data, 'listPrice');
        $this->inventoryLevel = GraphQLUtils::getProperty($data, 'inventoryLevel');
        $this->ai = GraphQLUtils::getClassProperty($data, 'ai', Ai::class);
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
