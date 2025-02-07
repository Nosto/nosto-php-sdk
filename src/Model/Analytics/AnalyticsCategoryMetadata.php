<?php

namespace Nosto\Model\Analytics;

class AnalyticsCategoryMetadata implements \JsonSerializable
{
    /**
     * @type string | null
     */
    private $category;
    /**
     * @type string | null
     */
    private $categoryId;

    public function __construct(
        $category = null,
        $categoryId = null
    )
    {
        $this->category = $category;
        $this->categoryId = $categoryId;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'category' => $this->category,
            'categoryId' => $this->categoryId,
        ];
    }
}

