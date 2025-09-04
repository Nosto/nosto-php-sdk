<?php

namespace Nosto\Result\Graphql\Search\SearchResult;

use JsonSerializable;
use Nosto\Util\GraphQLUtils;
use stdClass;

class ActiveVariation implements JsonSerializable
{
    /** @var ?string */
    private $id;

    public function __construct(stdClass $data)
    {
        $this->id = GraphQLUtils::getProperty($data, 'id');
    }

    /**
     * @return ?string
     */
    public function getId()
    {
        return $this->id;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
        ];
    }
}
