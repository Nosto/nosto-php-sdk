<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products\Hit;

use Nosto\Util\GraphQL;
use stdClass;

class Explain
{
    /** @var ?bool */
    private $match;

    /** @var ?float */
    private $value;

    /** @var ?string */
    private $description;

    /** @var Explain[] */
    private $details;

    public function __construct(stdClass $data)
    {
        $this->match = GraphQL::getProperty($data, 'match');
        $this->value = GraphQL::getProperty($data, 'value');
        $this->description = GraphQL::getProperty($data, 'description');
        $this->details = GraphQL::getArrayProperty($data, 'details', Explain::class, []);
    }

    /**
     * @return ?bool
     */
    public function getMatch()
    {
        return $this->match;
    }

    /**
     * @return float|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Explain[]
     */
    public function getDetails()
    {
        return $this->details;
    }
}