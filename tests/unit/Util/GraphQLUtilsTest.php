<?php

namespace Nosto\Test\Unit\Util;

use Codeception\TestCase\Test;
use Exception;
use Nosto\Util\GraphQLUtils;
use stdClass;

class GraphQLUtilsTest extends Test
{
    public function propertyValueProvider()
    {
        return [
            ['boolean value' => 'someRandomKey', true],
            ['string value' => 'someRandomKey', 'testValue'],
            ['int value' => 'someRandomKey', 187],
            ['float value' => 'someRandomKey', 1.87],
            ['array value' => 'someRandomKey', ['testValue']],
            ['null' => 'someRandomKey', null],
            ['empty value' => 'someRandomKey', ''],
            ['non existent key' => 'sabdsajkdas', null],
        ];
    }

    /**
     * @dataProvider  propertyValueProvider
     */
    public function testNormalPropertyIsReturned($key, $expectedValue) {
        $data = new stdClass();
        $data->someRandomKey = $expectedValue;

        $this->assertEquals($expectedValue, GraphQLUtils::getProperty($data, $key));
    }

    public function testDefaultValueIsReturnedForProperties() {
        $data = new stdClass();
        $expectedValue = 'theDefault';
        $data->someRandomKey = null;

        $this->assertEquals($expectedValue, GraphQLUtils::getProperty($data, 'someRandomKey', $expectedValue));
        $this->assertEquals($expectedValue, GraphQLUtils::getProperty($data, 'anotherRandomKey', $expectedValue));
    }

    public function testClassPropertyIsReturned() {
        $data = new stdClass();
        $expectedValue1 = 'test message';
        $expectedValue2 = '';
        $data->someRandomKey = $expectedValue1;
        $data->anotherRandomKey = $expectedValue2;

        $exception = GraphQLUtils::getClassProperty($data, 'someRandomKey', Exception::class);
        $this->assertInstanceOf(Exception::class, $exception);
        $this->assertEquals($expectedValue1, $exception->getMessage());

        $exception = GraphQLUtils::getClassProperty($data, 'anotherRandomKey', Exception::class);
        $this->assertInstanceOf(Exception::class, $exception);
        $this->assertEquals($expectedValue2, $exception->getMessage());
    }

    public function testDefaultValueIsReturnedForClassProperties() {
        $data = new stdClass();
        $expectedValue = new Exception('test message');
        $data->someRandomKey = null;

        $this->assertEquals(
            $expectedValue,
            GraphQLUtils::getClassProperty($data, 'someRandomKey', Exception::class, $expectedValue)
        );
        $this->assertEquals(
            $expectedValue,
            GraphQLUtils::getClassProperty($data, 'anotherRandomKey', Exception::class, $expectedValue)
        );
    }

    public function testArrayPropertyIsReturned() {
        $data = new stdClass();
        $data->someRandomKey = ['message1', 'message2', 'message3'];
        $data->anotherRandomKey = [];

        $exceptions = GraphQLUtils::getArrayProperty($data, 'someRandomKey', Exception::class);
        $this->assertCount(3, $exceptions);

        foreach ($exceptions as $key => $exception) {
            $expectedValue = 'message' . ($key + 1);

            $this->assertInstanceOf(Exception::class, $exception);
            $this->assertEquals($expectedValue, $exception->getMessage());
        }

        $this->assertEquals([], GraphQLUtils::getArrayProperty($data, 'anotherRandomKey', Exception::class));
    }

    public function testDefaultValueIsReturnedForArrayProperties() {
        $data = new stdClass();
        $expectedValue = [
            new Exception('message1'),
            new Exception('message2'),
        ];
        $data->someRandomKey = null;

        $this->assertEquals(
            $expectedValue,
            GraphQLUtils::getArrayProperty($data, 'someRandomKey', Exception::class, $expectedValue)
        );
        $this->assertEquals(
            $expectedValue,
            GraphQLUtils::getArrayProperty($data, 'anotherRandomKey', Exception::class, $expectedValue)
        );
    }
}
