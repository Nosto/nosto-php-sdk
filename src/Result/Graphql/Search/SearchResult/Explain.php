<?php

namespace Nosto\Result\Graphql\Search\SearchResult;

use Nosto\Result\Graphql\Search\SearchResult\Explain\MatchedRule;
use Nosto\Util\GraphQL;
use stdClass;

class Explain
{
    /** @var ?MatchedRule[] */
    private $matchedRules;

    public function __construct(stdClass $data)
    {
        $this->matchedRules = GraphQL::getArrayProperty($data, 'matchedRules', MatchedRule::class);
    }

    /**
     * @return ?MatchedRule[]
     */
    public function getMatchedRules()
    {
        return $this->matchedRules;
    }
}