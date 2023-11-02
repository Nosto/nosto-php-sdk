<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products;

use Nosto\Result\Graphql\Search\SearchResult\Products\Hit\Affinities;
use Nosto\Result\Graphql\Search\SearchResult\Products\Hit\Ai;
use Nosto\Result\Graphql\Search\SearchResult\Products\Hit\CustomField;
use Nosto\Result\Graphql\Search\SearchResult\Products\Hit\Explain;
use Nosto\Result\Graphql\Search\SearchResult\Products\Hit\Extra;
use Nosto\Result\Graphql\Search\SearchResult\Products\Hit\Sku;
use Nosto\Result\Graphql\Search\SearchResult\Products\Hit\Stats;
use Nosto\Result\Graphql\Search\SearchResult\Products\Hit\Variation;
use Nosto\Util\GraphQL;
use stdClass;

class Hit
{
    /** @var ?string */
    private $productId;

    /** @var ?string */
    private $url;

    /** @var ?string */
    private $name;

    /** @var ?string */
    private $imageUrl;

    /** @var ?string */
    private $thumbUrl;

    /** @var ?string */
    private $description;

    /** @var ?string */
    private $brand;

    /** @var ?string */
    private $variantId;

    /** @var ?string */
    private $availability;

    /** @var ?float */
    private $price;

    /** @var ?string */
    private $priceText;

    /** @var ?string[] */
    private $categoryIds;

    /** @var ?string[] */
    private $categories;

    /** @var ?string[] */
    private $tags1;

    /** @var ?string[] */
    private $tags2;

    /** @var ?string[] */
    private $tags3;

    /** @var ?CustomField[] */
    private $customFields;

    /** @var ?string */
    private $priceCurrencyCode;

    /** @var ?int */
    private $datePublished;

    /** @var ?float */
    private $listPrice;

    /** @var ?float */
    private $unitPricingBaseMeasure;

    /** @var ?string */
    private $unitPricingUnit;

    /** @var ?float */
    private $unitPricingMeasure;

    /** @var ?string */
    private $googleCategory;

    /** @var ?string */
    private $gtin;

    /** @var ?string */
    private $ageGroup;

    /** @var ?string */
    private $gender;

    /** @var ?string */
    private $condition;

    /** @var ?string[] */
    private $alternateImageUrls;

    /** @var ?float */
    private $ratingValue;

    /** @var ?int */
    private $reviewCount;

    /** @var ?int */
    private $inventoryLevel;

    /** @var ?float */
    private $supplierCost;

    /** @var ?Sku[] */
    private $skus;

    /** @var ?Variation[] */
    private $variations;

    /** @var ?string */
    private $pid;

    /** @var ?Stats */
    private $stats;

    /** @var ?bool */
    private $isExcluded;

    /** @var ?bool */
    private $onDiscount;

    /** @var ?Extra[] */
    private $extras;

    /** @var ?Explain */
    private $explain;

    /** @var ?float */
    private $score;

    /** @var ?bool */
    private $pinned;

    /** @var ?bool */
    private $saleable;

    /** @var ?bool */
    private $available;

    /** @var ?string[] */
    private $realVariantIds;

    /** @var ?Ai */
    private $ai;

    /** @var ?Affinities */
    private $affinities;

    public function __construct(stdClass $data)
    {
        $this->productId = GraphQL::getProperty($data, 'productId');
        $this->url = GraphQL::getProperty($data, 'url');
        $this->name = GraphQL::getProperty($data, 'name');
        $this->imageUrl = GraphQL::getProperty($data, 'imageUrl');
        $this->thumbUrl = GraphQL::getProperty($data, 'thumbUrl');
        $this->description = GraphQL::getProperty($data, 'description');
        $this->brand = GraphQL::getProperty($data, 'brand');
        $this->variantId = GraphQL::getProperty($data, 'variantId');
        $this->availability = GraphQL::getProperty($data, 'availability');
        $this->price = GraphQL::getProperty($data, 'price');
        $this->priceText = GraphQL::getProperty($data, 'priceText');
        $this->categoryIds = GraphQL::getProperty($data, 'categoryIds');
        $this->categories = GraphQL::getProperty($data, 'categories');
        $this->tags1 = GraphQL::getProperty($data, 'tags1');
        $this->tags2 = GraphQL::getProperty($data, 'tags2');
        $this->tags3 = GraphQL::getProperty($data, 'tags3');
        $this->customFields = GraphQL::getArrayProperty($data, 'customFields', CustomField::class);
        $this->priceCurrencyCode = GraphQL::getProperty($data, 'priceCurrencyCode');
        $this->datePublished = GraphQL::getProperty($data, 'datePublished');
        $this->listPrice = GraphQL::getProperty($data, 'listPrice');
        $this->unitPricingBaseMeasure = GraphQL::getProperty($data, 'unitPricingBaseMeasure');
        $this->unitPricingUnit = GraphQL::getProperty($data, 'unitPricingUnit');
        $this->unitPricingMeasure = GraphQL::getProperty($data, 'unitPricingMeasure');
        $this->googleCategory = GraphQL::getProperty($data, 'googleCategory');
        $this->gtin = GraphQL::getProperty($data, 'gtin');
        $this->ageGroup = GraphQL::getProperty($data, 'ageGroup');
        $this->gender = GraphQL::getProperty($data, 'gender');
        $this->condition = GraphQL::getProperty($data, 'condition');
        $this->alternateImageUrls = GraphQL::getProperty($data, 'alternateImageUrls');
        $this->ratingValue = GraphQL::getProperty($data, 'ratingValue');
        $this->reviewCount = GraphQL::getProperty($data, 'reviewCount');
        $this->inventoryLevel = GraphQL::getProperty($data, 'inventoryLevel');
        $this->supplierCost = GraphQL::getProperty($data, 'supplierCost');
        $this->skus = GraphQL::getArrayProperty($data, 'skus', Sku::class);
        $this->variations = GraphQL::getArrayProperty($data, 'variations', Variation::class);
        $this->pid = GraphQL::getProperty($data, 'pid');
        $this->stats = GraphQL::getClassProperty($data, 'stats', Stats::class);
        $this->isExcluded = GraphQL::getProperty($data, 'isExcluded');
        $this->onDiscount = GraphQL::getProperty($data, 'onDiscount');
        $this->extras = GraphQL::getArrayProperty($data, 'extra', Extra::class);
        $this->explain = GraphQL::getClassProperty($data, '_explain', Explain::class);
        $this->score = GraphQL::getProperty($data, '_score');
        $this->pinned = GraphQL::getProperty($data, '_pinned');
        $this->saleable = GraphQL::getProperty($data, 'saleable');
        $this->available = GraphQL::getProperty($data, 'available');
        $this->realVariantIds = GraphQL::getProperty($data, 'realVariantIds');
        $this->ai = GraphQL::getClassProperty($data, 'ai', Ai::class);
        $this->affinities = GraphQL::getClassProperty($data, 'affinities', Affinities::class);
    }

    /**
     * @return ?string
     */
    public function getProductId()
    {
        return $this->productId;
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
    public function getThumbUrl()
    {
        return $this->thumbUrl;
    }

    /**
     * @return ?string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return ?string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @return ?string
     */
    public function getVariantId()
    {
        return $this->variantId;
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
     * @return ?string[]
     */
    public function getCategoryIds()
    {
        return $this->categoryIds;
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
    public function getTags1()
    {
        return $this->tags1;
    }

    /**
     * @return ?string[]
     */
    public function getTags2()
    {
        return $this->tags2;
    }

    /**
     * @return ?string[]
     */
    public function getTags3()
    {
        return $this->tags3;
    }

    /**
     * @return ?CustomField[]
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }

    /**
     * @return ?string
     */
    public function getPriceCurrencyCode()
    {
        return $this->priceCurrencyCode;
    }

    /**
     * @return ?int
     */
    public function getDatePublished()
    {
        return $this->datePublished;
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
    public function getUnitPricingBaseMeasure()
    {
        return $this->unitPricingBaseMeasure;
    }

    /**
     * @return ?string
     */
    public function getUnitPricingUnit()
    {
        return $this->unitPricingUnit;
    }

    /**
     * @return ?float
     */
    public function getUnitPricingMeasure()
    {
        return $this->unitPricingMeasure;
    }

    /**
     * @return ?string
     */
    public function getGoogleCategory()
    {
        return $this->googleCategory;
    }

    /**
     * @return ?string
     */
    public function getGtin()
    {
        return $this->gtin;
    }

    /**
     * @return ?string
     */
    public function getAgeGroup()
    {
        return $this->ageGroup;
    }

    /**
     * @return ?string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return ?string
     */
    public function getCondition()
    {
        return $this->condition;
    }

    /**
     * @return ?string[]
     */
    public function getAlternateImageUrls()
    {
        return $this->alternateImageUrls;
    }

    /**
     * @return ?float
     */
    public function getRatingValue()
    {
        return $this->ratingValue;
    }

    /**
     * @return ?int
     */
    public function getReviewCount()
    {
        return $this->reviewCount;
    }

    /**
     * @return ?int
     */
    public function getInventoryLevel()
    {
        return $this->inventoryLevel;
    }

    /**
     * @return ?float
     */
    public function getSupplierCost()
    {
        return $this->supplierCost;
    }

    /**
     * @return ?Sku[]
     */
    public function getSkus()
    {
        return $this->skus;
    }

    /**
     * @return ?Variation[]
     */
    public function getVariations()
    {
        return $this->variations;
    }

    /**
     * @return ?string
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @return ?Stats
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * @return ?bool
     */
    public function getIsExcluded()
    {
        return $this->isExcluded;
    }

    /**
     * @return ?bool
     */
    public function getOnDiscount()
    {
        return $this->onDiscount;
    }

    /**
     * @return ?Extra[]
     */
    public function getExtras()
    {
        return $this->extras;
    }

    /**
     * @return ?Explain
     */
    public function getExplain()
    {
        return $this->explain;
    }

    /**
     * @return ?float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return ?bool
     */
    public function getPinned()
    {
        return $this->pinned;
    }

    /**
     * @return ?bool
     */
    public function getSaleable()
    {
        return $this->saleable;
    }

    /**
     * @return ?bool
     */
    public function getAvailable()
    {
        return $this->available;
    }

    /**
     * @return ?string[]
     */
    public function getRealVariantIds()
    {
        return $this->realVariantIds;
    }

    /**
     * @return ?Ai
     */
    public function getAi()
    {
        return $this->ai;
    }

    /**
     * @return ?Affinities
     */
    public function getAffinities()
    {
        return $this->affinities;
    }
}
