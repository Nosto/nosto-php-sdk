<?php
/**
 * Copyright (c) 2026, Nosto Solutions Ltd
 * All rights reserved.
 */

namespace Nosto\Util;

class SearchTypeReason
{
    const DEFAULT_SEARCH_TYPE_REASON = 'unknown';

    /**
     * @param mixed $searchTypeReason
     * @return string
     */
    public static function normalize($searchTypeReason)
    {
        if (!is_string($searchTypeReason)) {
            return self::DEFAULT_SEARCH_TYPE_REASON;
        }

        $searchTypeReason = trim($searchTypeReason);
        if ($searchTypeReason === '') {
            return self::DEFAULT_SEARCH_TYPE_REASON;
        }

        return $searchTypeReason;
    }
}
