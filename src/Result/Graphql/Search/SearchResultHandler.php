<?php

namespace Nosto\Result\Graphql\Search;

use Nosto\Result\Graphql\GraphQLResultHandler;
use stdClass;

class SearchResultHandler extends GraphQLResultHandler
{
    protected function parseQueryResult(stdClass $stdClass)
    {
        return new SearchResult($stdClass->search);
    }
}
