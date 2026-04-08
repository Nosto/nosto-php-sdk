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
     * @type string
     */
    private $searchType;
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

    public function __construct(
        $query = null,
        $resultId = null,
        $organic = false,
        $autoCorrect = true,
        $autoComplete = false,
        $searchType = 'keyword',
        $sorted = true,
        $hasResults = true,
        $refined = false
    )
    {
        $this->query = $query;
        $this->resultId = $resultId ?: uniqid();
        $this->organic = $organic;
        $this->autoCorrect = $autoCorrect;
        $this->autoComplete = $autoComplete;
        $this->searchType = $searchType;
        $this->sorted = $sorted;
        $this->hasResults = $hasResults;
        $this->refined = $refined;
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
        return $this->searchType === 'keyword';
    }

    /**
     * @return string
     */
    public function searchType()
    {
        return $this->searchType;
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
            'keyword' => $this->keyword(),
            'searchType' => $this->searchType,
            'sorted' => $this->sorted,
            'hasResults' => $this->hasResults,
            'refined' => $this->refined
        ];
    }
}
