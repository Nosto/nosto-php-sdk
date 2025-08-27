<?php
/**
 * Copyright (c) 2025, Nosto Solutions Ltd
 * All rights reserved.
 */

namespace Nosto\Result\Api;

use Nosto\Request\Http\HttpResponse;

class CustomGraphQLResultHandler extends ApiResultHandler
{
    /**
     * @inheritdoc
     */
    protected function parseAPIResult(HttpResponse $response)
    {
        $jsonResult = $response->getJsonResult();

        return [
            'success' => $response->getCode() === 200,
            'statusCode' => $response->getCode(),
            'data' => $jsonResult,
            'errors' => isset($jsonResult['errors']) ? $jsonResult['errors'] : null,
            'rawResponse' => $response->getRawResult()
        ];
    }
}
