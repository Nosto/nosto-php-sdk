<?php

namespace Nosto\Model\Analytics;

class AnalyticsTrackingPayload implements \JsonSerializable
{
    private ?string $query;
    private ?string $productNumber;
    private string $resultId;
    private bool $isOrganic;
    private bool $isAutoCorrect;
    private bool $isAutoComplete;
    private bool $isKeyword;
    private bool $isSorted;
    private bool $hasResults;
    private bool $isRefined;

    public function __construct(
        ?string $query = null,
        ?string $productNumber = null,
        ?string $resultId = null,
        bool $isOrganic = false,
        bool $isAutoCorrect = true,
        bool $isAutoComplete = false,
        bool $isKeyword = false,
        bool $isSorted = true,
        bool $hasResults = true,
        bool $isRefined = false
    ) {
        $this->query = $query;
        $this->productNumber = $productNumber;
        $this->resultId = $resultId ?: uniqid();
        $this->isOrganic = $isOrganic;
        $this->isAutoCorrect = $isAutoCorrect;
        $this->isAutoComplete = $isAutoComplete;
        $this->isKeyword = $isKeyword;
        $this->isSorted = $isSorted;
        $this->hasResults = $hasResults;
        $this->isRefined = $isRefined;
    }

    public function getQuery(): ?string
    {
        return $this->query;
    }

    public function getProductNumber(): ?string
    {
        return $this->productNumber;
    }

    public function getResultId(): string
    {
        return $this->resultId;
    }

    public function isOrganic(): bool
    {
        return $this->isOrganic;
    }

    public function isAutoCorrect(): bool
    {
        return $this->isAutoCorrect;
    }

    public function isAutoComplete(): bool
    {
        return $this->isAutoComplete;
    }

    public function isKeyword(): bool
    {
        return $this->isKeyword;
    }

    public function isSorted(): bool
    {
        return $this->isSorted;
    }

    public function hasResults(): bool
    {
        return $this->hasResults;
    }

    public function isRefined(): bool
    {
        return $this->isRefined;
    }

    public function jsonSerialize(): array
    {
        return [
            'query' => $this->query,
            'productNumber' => $this->productNumber,
            'resultId' => $this->resultId,
            'isOrganic' => $this->isOrganic,
            'isAutoCorrect' => $this->isAutoCorrect,
            'isAutoComplete' => $this->isAutoComplete,
            'isKeyword' => $this->isKeyword,
            'isSorted' => $this->isSorted,
            'hasResults' => $this->hasResults,
            'isRefined' => $this->isRefined,
        ];
    }
}

