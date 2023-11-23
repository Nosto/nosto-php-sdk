<?php

namespace Nosto\Result\Graphql\Search\SearchResult\Products;

use Exception;
use Nosto\Util\GraphQLUtils;
use stdClass;

abstract class Facet
{
    const STATS_TYPE = 'stats';

    const TERMS_TYPE = 'terms';

    /** @var ?string */
    private $id;

    /** @var ?string */
    private $name;

    /** @var ?string */
    private $field;

    /** @var ?string */
    private $type;

    public function __construct(stdClass $data)
    {
        $this->id = GraphQLUtils::getProperty($data, 'id');
        $this->name = GraphQLUtils::getProperty($data, 'name');
        $this->field = GraphQLUtils::getProperty($data, 'field');
        $this->type = GraphQLUtils::getProperty($data, 'type');
    }

    /**
     * @return Facet
     * @throws Exception
     */
    public static function getInstance(stdClass $facet)
    {
        switch ($facet->type) {
            case self::STATS_TYPE:
                return new StatsFacet($facet);
            case self::TERMS_TYPE:
                return new TermsFacet($facet);
            default:
                return new BasicFacet($facet);
        }
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
     * @return ?string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @return ?string
     */
    public function getType()
    {
        return $this->type;
    }
}
