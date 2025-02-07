<?php

namespace Nosto\Model\Analytics;

class AnalyticsSearchMetadata implements \JsonSerializable
{
    /**
     * @type string
     */
    private $query;
    /**
     * @type string
     */
    private $resultId;
    /**
     * @type bool
     */
    private $isOrganic;
    /**
     * @type bool
     */
    private $isAutoCorrect;
    /**
     * @type bool
     */
    private $isAutoComplete;
    /**
     * @type bool
     */
    private $isKeyword;
    /**
     * @type bool
     */
    private $isSorted;
    /**
     * @type bool
     */
    private $hasResults;
    /**
     * @type bool
     */
    private $isRefined;

    public function __construct(
        $query = null,
        $resultId = null,
        $isOrganic = false,
        $isAutoCorrect = true,
        $isAutoComplete = false,
        $isKeyword = false,
        $isSorted = true,
        $hasResults = true,
        $isRefined = false
    )
    {
        $this->query = $query;
        $this->resultId = $resultId ?: uniqid();
        $this->isOrganic = $isOrganic;
        $this->isAutoCorrect = $isAutoCorrect;
        $this->isAutoComplete = $isAutoComplete;
        $this->isKeyword = $isKeyword;
        $this->isSorted = $isSorted;
        $this->hasResults = $hasResults;
        $this->isRefined = $isRefined;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function getResultId()
    {
        return $this->resultId;
    }

    /**
     * @return bool
     */
    public function isOrganic()
    {
        return $this->isOrganic;
    }

    /**
     * @return bool
     */
    public function isAutoCorrect()
    {
        return $this->isAutoCorrect;
    }

    /**
     * @return bool
     */
    public function isAutoComplete()
    {
        return $this->isAutoComplete;
    }

    /**
     * @return bool
     */
    public function isKeyword()
    {
        return $this->isKeyword;
    }

    /**
     * @return bool
     */
    public function isSorted()
    {
        return $this->isSorted;
    }

    /**
     * @return bool
     */
    public function hasResults()
    {
        return $this->hasResults;
    }

    /**
     * @return bool
     */
    public function isRefined()
    {
        return $this->isRefined;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'query' => $this->query,
            'resultId' => $this->resultId,
            'isOrganic' => $this->isOrganic,
            'isAutoCorrect' => $this->isAutoCorrect,
            'isAutoComplete' => $this->isAutoComplete,
            'isKeyword' => $this->isKeyword,
            'isSorted' => $this->isSorted,
            'hasResults' => $this->hasResults,
            'isRefined' => $this->isRefined
        ];
    }
}

