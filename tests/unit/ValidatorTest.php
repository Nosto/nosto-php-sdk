<?php

require_once(dirname(__FILE__) . '/../_support/ValidatableObject.php');

class ValidatorTest extends \Codeception\TestCase\Test
{
    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * Tests the validator component.
     */
    public function testValidator()
    {
        $object = new ValidatableObject();

        $this->specify('valid object', function() use ($object) {
            $validator = new NostoValidator($object);
            $result = $validator->validate();
            $this->assertTrue($result);
            $this->assertFalse($validator->hasErrors());
            $this->assertEmpty($validator->getErrors());
        });

        $this->specify('invalid object', function() use ($object) {
            $object->setNumber('foo');
            $validator = new NostoValidator($object);
            $result = $validator->validate();
            $this->assertFalse($result);
            $this->assertTrue($validator->hasErrors());
            $this->assertNotEmpty($validator->getErrors());
        });
    }

    /**
     * Test the validator rule format.
     */
    public function testValidatorRuleFormat()
    {
        $this->setExpectedException('NostoException');

        $object = new ValidatableObject();
        $object->setValidationRules(array(array('id')));
        $validator =  new NostoValidator($object);
        $validator->validate();
    }

    /**
     * Test to create a invalid validator instance.
     */
    public function testInvalidValidator()
    {
        $this->setExpectedException('NostoException');

        $object = new ValidatableObject();
        $object->setValidationRules(array(array('id'), 'unknown'));
        $validator =  new NostoValidator($object);
        $validator->validate();
    }

    /**
     * Test to a validator with invalid arguments.
     */
    public function testValidatorInvalidArguments()
    {
        $this->setExpectedException('NostoException');

        $object = new ValidatableObject();
        $object->setValidationRules(array(array('id'), 'required', 'foo' => 'bar'));
        $validator =  new NostoValidator($object);
        $validator->validate();
    }

    /**
     * Tests the number validator.
     */
    public function testNumberValidator()
    {
        $object = new ValidatableObject();

        $this->specify('valid decimal', function() use ($object) {
            $object->setNumber(5.5);
            $validator = NostoValidator::forgeValidator('number', $object, array('number'));
            $result = $validator->validate();
            $this->assertTrue($result);
            $this->assertFalse($validator->hasErrors());
            $this->assertEmpty($validator->getErrors());
        });

        $this->specify('valid decimal as string', function() use ($object) {
            $object->setNumber('5.99');
            $validator = NostoValidator::forgeValidator('number', $object, array('number'));
            $result = $validator->validate();
            $this->assertTrue($result);
            $this->assertFalse($validator->hasErrors());
            $this->assertEmpty($validator->getErrors());
        });

        $this->specify('valid integer', function() use ($object) {
            $object->setNumber(5);
            $validator = NostoValidator::forgeValidator('number', $object, array('number'), array('integer' => true));
            $result = $validator->validate();
            $this->assertTrue($result);
            $this->assertFalse($validator->hasErrors());
            $this->assertEmpty($validator->getErrors());
        });

        $this->specify('valid integer as string', function() use ($object) {
            $object->setNumber('5');
            $validator = NostoValidator::forgeValidator('number', $object, array('number'), array('integer' => true));
            $result = $validator->validate();
            $this->assertTrue($result);
            $this->assertFalse($validator->hasErrors());
            $this->assertEmpty($validator->getErrors());
        });

        $this->specify('invalid number', function() use ($object) {
            $object->setNumber('test123');
            $validator = NostoValidator::forgeValidator('number', $object, array('number'));
            $result = $validator->validate();
            $this->assertFalse($result);
            $this->assertTrue($validator->hasErrors());
            $this->assertNotEmpty($validator->getErrors());
        });

        $this->specify('invalid integer', function() use ($object) {
            $object->setNumber('2.2');
            $validator = NostoValidator::forgeValidator('number', $object, array('number'), array('integer' => true));
            $result = $validator->validate();
            $this->assertFalse($result);
            $this->assertTrue($validator->hasErrors());
            $this->assertNotEmpty($validator->getErrors());
        });
    }

    /**
     * Tests the range validator.
     */
    public function testRangeValidator()
    {
        $object = new ValidatableObject();

        $this->specify('valid range', function() use ($object) {
            $object->setIn(2);
            $validator = NostoValidator::forgeValidator('in', $object, array('in'), array('range' => array(1,2,3)));
            $result = $validator->validate();
            $this->assertTrue($result);
            $this->assertFalse($validator->hasErrors());
            $this->assertEmpty($validator->getErrors());
        });

        $this->specify('invalid range', function() use ($object) {
            $object->setIn(5);
            $validator = NostoValidator::forgeValidator('in', $object, array('in'), array('range' => array(1,2,3)));
            $result = $validator->validate();
            $this->assertFalse($result);
            $this->assertTrue($validator->hasErrors());
            $this->assertNotEmpty($validator->getErrors());
        });
    }

    /**
     * Tests the range validator without supplied range.
     */
    public function testRangeValidatorWithoutRange()
    {
        $this->setExpectedException('NostoException');

        $object = new ValidatableObject();
        $validator = NostoValidator::forgeValidator('in', $object, array('in'));
        $validator->validate();
    }

    /**
     * Tests the required validator.
     */
    public function testRequiredValidator()
    {
        $object = new ValidatableObject();

        $this->specify('property id is set and required', function() use ($object) {
            $object->setId(2);
            $validator = NostoValidator::forgeValidator('required', $object, array('id'));
            $result = $validator->validate();
            $this->assertTrue($result);
            $this->assertFalse($validator->hasErrors());
            $this->assertEmpty($validator->getErrors());
        });

        $this->specify('property id is not set but required', function() use ($object) {
            $object->setId(null);
            $validator = NostoValidator::forgeValidator('required', $object, array('id'));
            $result = $validator->validate();
            $this->assertFalse($result);
            $this->assertTrue($validator->hasErrors());
            $this->assertNotEmpty($validator->getErrors());
        });
    }

    /**
     * Tests the required validator on an invalid attribute.
     */
    public function testRequiredValidatorWithInvalidAttribute()
    {
        $this->setExpectedException('NostoException');

        $object = new ValidatableObject();
        $validator = NostoValidator::forgeValidator('required', $object, array('unknown'));
        $validator->validate();
    }

    /**
     * Tests the currency validator.
     */
    public function testCurrencyValidator()
    {
        $object = new ValidatableObject();

        $this->specify('valid ISO 4217 currency', function() use ($object) {
                $validator = NostoValidator::forgeValidator('currency', $object, array('currency'), array('standard' => 'iso-4217'));
                $result = $validator->validate();
                $this->assertTrue($result);
                $this->assertFalse($validator->hasErrors());
                $this->assertEmpty($validator->getErrors());
            });

        $this->specify('invalid ISO 4217 currency', function() use ($object) {
                $object->setCurrency('foo');
                $validator = NostoValidator::forgeValidator('currency', $object, array('currency'), array('standard' => 'iso-4217'));
                $result = $validator->validate();
                $this->assertFalse($result);
                $this->assertTrue($validator->hasErrors());
                $this->assertNotEmpty($validator->getErrors());
            });
    }

    /**
     * Tests the currency validator with an invalid currency standard.
     */
    public function testCurrencyValidatorWithInvalidStandard()
    {
        $this->setExpectedException('NostoException');

        $object = new ValidatableObject();
        $validator = NostoValidator::forgeValidator('currency', $object, array('currency'), array('standard' => 'unknown'));
        $validator->validate();
    }

    /**
     * Tests the currency validator without the currency standard.
     */
    public function testCurrencyValidatorWithoutStandard()
    {
        $this->setExpectedException('NostoException');

        $object = new ValidatableObject();
        $validator = NostoValidator::forgeValidator('currency', $object, array('currency'));
        $validator->validate();
    }
}
