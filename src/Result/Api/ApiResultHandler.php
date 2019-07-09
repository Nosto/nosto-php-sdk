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
        $this->renderAPIResult();
    }

    abstract protected function renderAPIResult();


    /**
     * Parses errors from HttpResponse
     * @param HttpResponse $response
     * @return string
     */
    public static function parseErrorsFromResponse(HttpResponse $response)
    {
        $json = $response->getJsonResult();
        $errorStr = '';
        if (isset($json->errors)
            && is_array($json->errors)
            && !empty($json->errors)
        ) {
            foreach ($json->errors as $stdClassError) {
                if (isset($stdClassError->errors)) {
                    $errorStr .= $stdClassError->errors;
                }
                if (isset($stdClassError->product_id)) {
                    $errorStr .= sprintf('(product #%s)', $stdClassError->product_id);
                }
            }
        }

        return $errorStr;
    }

}