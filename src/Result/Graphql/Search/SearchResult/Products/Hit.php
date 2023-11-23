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
use Nosto\Util\GraphQLUtils;
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
        $this->productId = GraphQLUtils::getProperty($data, 'productId');
        $this->url = GraphQLUtils::getProperty($data, 'url');
        $this->name = GraphQLUtils::getProperty($data, 'name');
        $this->imageUrl = GraphQLUtils::getProperty($data, 'imageUrl');
        $this->thumbUrl = GraphQLUtils::getProperty($data, 'thumbUrl');
        $this->description = GraphQLUtils::getProperty($data, 'description');
        $this->brand = GraphQLUtils::getProperty($data, 'brand');
        $this->variantId = GraphQLUtils::getProperty($data, 'variantId');
        $this->availability = GraphQLUtils::getProperty($data, 'availability');
        $this->price = GraphQLUtils::getProperty($data, 'price');
        $this->priceText = GraphQLUtils::getProperty($data, 'priceText');
        $this->categoryIds = GraphQLUtils::getProperty($data, 'categoryIds');
        $this->categories = GraphQLUtils::getProperty($data, 'categories');
        $this->tags1 = GraphQLUtils::getProperty($data, 'tags1');
        $this->tags2 = GraphQLUtils::getProperty($data, 'tags2');
        $this->tags3 = GraphQLUtils::getProperty($data, 'tags3');
        $this->customFields = GraphQLUtils::getArrayProperty($data, 'customFields', CustomField::class);
        $this->priceCurrencyCode = GraphQLUtils::getProperty($data, 'priceCurrencyCode');
        $this->datePublished = GraphQLUtils::getProperty($data, 'datePublished');
        $this->listPrice = GraphQLUtils::getProperty($data, 'listPrice');
        $this->unitPricingBaseMeasure = GraphQLUtils::getProperty($data, 'unitPricingBaseMeasure');
        $this->unitPricingUnit = GraphQLUtils::getProperty($data, 'unitPricingUnit');
        $this->unitPricingMeasure = GraphQLUtils::getProperty($data, 'unitPricingMeasure');
        $this->googleCategory = GraphQLUtils::getProperty($data, 'googleCategory');
        $this->gtin = GraphQLUtils::getProperty($data, 'gtin');
        $this->ageGroup = GraphQLUtils::getProperty($data, 'ageGroup');
        $this->gender = GraphQLUtils::getProperty($data, 'gender');
        $this->condition = GraphQLUtils::getProperty($data, 'condition');
        $this->alternateImageUrls = GraphQLUtils::getProperty($data, 'alternateImageUrls');
        $this->ratingValue = GraphQLUtils::getProperty($data, 'ratingValue');
        $this->reviewCount = GraphQLUtils::getProperty($data, 'reviewCount');
        $this->inventoryLevel = GraphQLUtils::getProperty($data, 'inventoryLevel');
        $this->supplierCost = GraphQLUtils::getProperty($data, 'supplierCost');
        $this->skus = GraphQLUtils::getArrayProperty($data, 'skus', Sku::class);
        $this->variations = GraphQLUtils::getArrayProperty($data, 'variations', Variation::class);
        $this->pid = GraphQLUtils::getProperty($data, 'pid');
        $this->stats = GraphQLUtils::getClassProperty($data, 'stats', Stats::class);
        $this->isExcluded = GraphQLUtils::getProperty($data, 'isExcluded');
        $this->onDiscount = GraphQLUtils::getProperty($data, 'onDiscount');
        $this->extras = GraphQLUtils::getArrayProperty($data, 'extra', Extra::class);
        $this->explain = GraphQLUtils::getClassProperty($data, '_explain', Explain::class);
        $this->score = GraphQLUtils::getProperty($data, '_score');
        $this->pinned = GraphQLUtils::getProperty($data, '_pinned');
        $this->saleable = GraphQLUtils::getProperty($data, 'saleable');
        $this->available = GraphQLUtils::getProperty($data, 'available');
        $this->realVariantIds = GraphQLUtils::getProperty($data, 'realVariantIds');
        $this->ai = GraphQLUtils::getClassProperty($data, 'ai', Ai::class);
        $this->affinities = GraphQLUtils::getClassProperty($data, 'affinities', Affinities::class);
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
