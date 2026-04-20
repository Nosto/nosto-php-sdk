<?php
/**
 * Copyright (c) 2026, Nosto Solutions Ltd
 * All rights reserved.
 */

namespace Nosto\Util;

class SearchType
{
    const DEFAULT_SEARCH_TYPE = 'unknown';

    /**
     * @param mixed $searchType
     * @return string
     */
    public static function normalize($searchType)
    {
        if (!is_string($searchType)) {
            return self::DEFAULT_SEARCH_TYPE;
        }

        $searchType = trim($searchType);
        if ($searchType === '') {
            return self::DEFAULT_SEARCH_TYPE;
        }

        return $searchType;
    }
}
