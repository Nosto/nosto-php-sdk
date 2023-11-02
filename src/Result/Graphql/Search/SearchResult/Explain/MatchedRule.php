<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Explain;

use Nosto\Util\GraphQL;
use stdClass;

class MatchedRule
{
    /** @var ?string */
    private $id;

    /** @var ?string */
    private $name;

    /** @var ?stdClass */
    private $set;

    public function __construct(stdClass $data)
    {
        $this->id = GraphQL::getProperty($data, 'id');
        $this->name = GraphQL::getProperty($data, 'name');
        $this->set = GraphQL::getProperty($data, 'set');
    }

    /**
     * @return ?string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ?string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return ?stdClass
     */
    public function getSet()
    {
        return $this->set;
    }
}