<?php

namespace Nosto\Test\Unit\Util;

use Codeception\TestCase\Test;
use Exception;
use Nosto\Util\GraphQL;
use stdClass;

class GraphQLTest extends Test
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
            ['non existent key' => 'sabdsajkdas', null],
        ];
    }

    /**
     * @dataProvider  propertyValueProvider
     */
    public function testNormalPropertyIsReturned($key, $expectedValue) {
        $data = new stdClass();
        $data->someRandomKey = $expectedValue;

        $this->assertEquals($expectedValue, GraphQL::getProperty($data, $key));
    }

    public function testDefaultValueIsReturnedForProperties() {
        $data = new stdClass();
        $expectedValue = 'theDefault';
        $data->someRandomKey = null;

        $this->assertEquals($expectedValue, GraphQL::getProperty($data, 'someRandomKey', $expectedValue));
        $this->assertEquals($expectedValue, GraphQL::getProperty($data, 'anotherRandomKey', $expectedValue));
    }

    public function testClassPropertyIsReturned() {
        $data = new stdClass();
        $expectedValue = 'test message';
        $data->someRandomKey = $expectedValue;

        $exception = GraphQL::getClassProperty($data, 'someRandomKey', Exception::class);
        $this->assertInstanceOf(Exception::class, $exception);
        $this->assertEquals($expectedValue, $exception->getMessage());
    }

    public function testDefaultValueIsReturnedForClassProperties() {
        $data = new stdClass();
        $expectedValue = new Exception('test message');
        $data->someRandomKey = null;

        $this->assertEquals(
            $expectedValue,
            GraphQL::getClassProperty($data, 'someRandomKey', Exception::class, $expectedValue)
        );
        $this->assertEquals(
            $expectedValue,
            GraphQL::getClassProperty($data, 'anotherRandomKey', Exception::class, $expectedValue)
        );
    }

    public function testArrayPropertyIsReturned() {
        $data = new stdClass();
        $data->someRandomKey = ['message1', 'message2', 'message3'];

        $exceptions = GraphQL::getArrayProperty($data, 'someRandomKey', Exception::class);
        $this->assertCount(3, $exceptions);

        foreach ($exceptions as $key => $exception) {
            $expectedValue = 'message' . ($key + 1);

            $this->assertInstanceOf(Exception::class, $exception);
            $this->assertEquals($expectedValue, $exception->getMessage());
        }
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
            GraphQL::getArrayProperty($data, 'someRandomKey', Exception::class, $expectedValue)
        );
        $this->assertEquals(
            $expectedValue,
            GraphQL::getArrayProperty($data, 'anotherRandomKey', Exception::class, $expectedValue)
        );
    }
}
