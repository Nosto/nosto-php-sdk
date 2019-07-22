<?php
/**
 * Created by PhpStorm.
 * User: olsiqose
 * Date: 09/07/2019
 * Time: 11.51
 */

namespace Nosto\Result\Api;

use Nosto\Result\ResultHandler;
use Nosto\Request\Http\HttpResponse;

abstract class ApiResultHandler extends ResultHandler
{

    protected function parseResponse(HttpResponse $response)
    {
        return $this->parseAPIResult($response);
    }

    /**
     * @param HttpResponse $response
     * @return string|array
     */
    abstract protected function parseAPIResult(HttpResponse $response);

}
