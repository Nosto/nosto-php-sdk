<?php

namespace Nosto\Model\Analytics;

class AnalyticsSearchMetadataForGraphql implements \JsonSerializable
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
    private $organic;
    /**
     * @type bool
     */
    private $autoCorrect;
    /**
     * @type bool
     */
    private $autoComplete;
    /**
     * @type bool
     */
    private $keyword;
    /**
     * @type bool
     */
    private $sorted;
    /**
     * @type bool
     */
    private $hasResults;
    /**
     * @type bool
     */
    private $refined;
    /**
     * @type string|null
     */
    private $searchType;

    public function __construct(
        $query = null,
        $resultId = null,
        $organic = false,
        $autoCorrect = true,
        $autoComplete = false,
        $keyword = false,
        $sorted = true,
        $hasResults = true,
        $refined = false,
        $searchType = null
    )
    {
        $this->query = $query;
        $this->resultId = $resultId ?: uniqid();
        $this->organic = $organic;
        $this->autoCorrect = $autoCorrect;
        $this->autoComplete = $autoComplete;
        $this->keyword = $keyword;
        $this->sorted = $sorted;
        $this->hasResults = $hasResults;
        $this->refined = $refined;
        $this->searchType = $searchType;
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
    public function organic()
    {
        return $this->organic;
    }

    /**
     * @return bool
     */
    public function autoCorrect()
    {
        return $this->autoCorrect;
    }

    /**
     * @return bool
     */
    public function autoComplete()
    {
        return $this->autoComplete;
    }

    /**
     * @return bool
     */
    public function keyword()
    {
        return $this->keyword;
    }

    /**
     * @return bool
     */
    public function sorted()
    {
        return $this->sorted;
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
    public function refined()
    {
        return $this->refined;
    }

    /**
     * @return string|null
     */
    public function searchType()
    {
        return $this->searchType;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'query' => $this->query,
            'resultId' => $this->resultId,
            'organic' => $this->organic,
            'autoCorrect' => $this->autoCorrect,
            'autoComplete' => $this->autoComplete,
            'keyword' => $this->keyword,
            'searchType' => $this->searchType,
            'sorted' => $this->sorted,
            'hasResults' => $this->hasResults,
            'refined' => $this->refined
        ];
    }
}
