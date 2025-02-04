<?php

namespace Nosto\Model\Analytics;

class DataSource
{
    const SEARCH = 'search';
    const CATEGORY = 'category';

    private string $type;

    private function __construct(string $type)
    {
        $this->type = $type;
    }

    public static function search(): self
    {
        return new self(self::SEARCH);
    }

    public static function category(): self
    {
        return new self(self::CATEGORY);
    }

    public static function fromString(string $type): self
    {
        switch ($type) {
            case self::SEARCH:
                return self::search();
            case self::CATEGORY:
                return self::category();
            default:
                throw new \InvalidArgumentException('Invalid dataSource type: ' . $type);
        }
    }

    public function getType(): string
    {
        return $this->type;
    }
}
