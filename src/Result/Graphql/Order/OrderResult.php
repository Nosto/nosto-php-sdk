<?php
/**
 * Created by PhpStorm.
 * User: olsiqose
 * Date: 03/07/2019
 * Time: 16.52
 */

namespace Nosto\Result\Graphql\Order;

use Nosto\NostoException;
use Nosto\Request\Http\HttpResponse;

class OrderResult
{
    const GRAPHQL_RESPONSE_ERROR = 'errors';
    const GRAPHQL_RESPONSE_SUCCESS = 'data';
    const GRAPHQL_RESPONSE_UPDATE_STATUS = 'updateStatus';
    const GRAPHQL_ORDER_ID = 'id';

    /**
     * @param HttpResponse $response
     * @return mixed|null
     * @throws NostoException
     */
    public static function parseResult(HttpResponse $response)
    {
        $result = json_decode($response->getResult());
        $members = get_object_vars($result);

        //Check for errors
        if (array_key_exists(self::GRAPHQL_RESPONSE_ERROR, $members)) {
            foreach ($members as $varName => $member)
            {
                if ($varName === self::GRAPHQL_RESPONSE_ERROR) {
                    self::parseErrorMessage($member);
                }
            }
            return null;
        }

        //Parse results
        foreach ($members as $varName => $member)
        {
            if ($varName === self::GRAPHQL_RESPONSE_SUCCESS) {
                return self::parseSuccessMessage($member);
            }
        }
        return null;
    }

    /**
     * @param array $errorClass
     * @throws NostoException
     */
    public static function parseErrorMessage(array $errors)
    {
        if (count($errors) > 0) {
            $message = $errors[0]->message;
            throw new NostoException($message);
        }
    }

    /**
     * @param \stdClass $stdClass
     * @return mixed
     */
    public static function parseSuccessMessage(\stdClass $stdClass)
    {
        $members = get_object_vars($stdClass);
        foreach ($members as $varName => $member) {
            if ($varName === self::GRAPHQL_ORDER_ID ||
                $varName === self::GRAPHQL_RESPONSE_UPDATE_STATUS) {
                return $member;
            }
            if ($member instanceof \stdClass) {
                return self::parseSuccessMessage($member);
            }
        }
    }
}