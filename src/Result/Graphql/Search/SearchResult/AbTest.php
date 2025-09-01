<?php

namespace Nosto\Result\Graphql\Search\SearchResult;

use JsonSerializable;
use Nosto\Util\GraphQLUtils;
use stdClass;

class AbTest implements JsonSerializable
{
    /** @var ?string */
    private $id;

    /** @var ?ActiveVariation */
    private $activeVariation;

    public function __construct(stdClass $data)
    {
        $this->activeVariation = GraphQLUtils::getProperty($data, 'activeVariation', ActiveVariation::class);
        $this->id = GraphQLUtils::getProperty($data, 'id');
    }

    /**
     * @return ?ActiveVariation
     */
    public function getActiveVariation()
    {
        return $this->activeVariation;
    }

    /**
     * @return string|null
     */
    public function getId()
    {
        return $this->id;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'activeVariation' => $this->activeVariation,
        ];
    }
}
