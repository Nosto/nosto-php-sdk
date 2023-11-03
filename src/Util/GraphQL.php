<?php

namespace Nosto\Util;

use stdClass;

class GraphQL
{
    public static function getProperty(stdClass $data, $propertyName, $default = null)
    {
        return property_exists($data, $propertyName) && !is_null($data->$propertyName)
            ? $data->$propertyName
            : $default;
    }

    public static function getClassProperty(stdClass $data, $propertyName, $className, $default = null)
    {
        return property_exists($data, $propertyName) && !is_null($data->$propertyName)
            ? new $className($data->$propertyName)
            : $default;
    }

    public static function getArrayProperty(stdClass $data, $propertyName, $className, $default = null)
    {
        return property_exists($data, $propertyName) && !is_null($data->$propertyName)
            ? array_map(
                function ($value) use ($className) {
                    return new $className($value);
                },
                $data->$propertyName
            )
            : $default;
    }
}
