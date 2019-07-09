<?php
/**
 * Created by PhpStorm.
 * User: olsiqose
 * Date: 09/07/2019
 * Time: 11.51
 */

namespace Nosto\Result\Api;

final class GeneralPurposeResultHandler extends ApiResultHandler
{
    public static function getInstance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new self();
        }
        return $inst;
    }

    protected function renderAPIResult()
    {
        return true;
    }

}