<?php

class ValidatableObject extends NostoObject implements NostoValidatableInterface
{
    protected $_id = 1;
    protected $_name = 'Test';
    protected $_number = 1.1;
    protected $_in = 1;
    protected $_currency = 'EUR';

    private $rules = array(
        array(array('id', 'name'), 'required'),
        array(array('id'), 'number', 'integer' => true),
        array(array('number'), 'number'),
        array(array('in'), 'in', 'range' => array(1,2)),
        array(array('currency'), 'currency', 'standard' => 'iso-4217'),
    );

    public function setValidationRules($rules)
    {
        $this->rules = $rules;
    }

    public function getValidationRules()
    {
        return $this->rules;
    }

    public function setId($id)
    {
        $this->_id = $id;
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setNumber($number)
    {
        $this->_number = $number;
    }

    public function getNumber()
    {
        return $this->_number;
    }

    public function setIn($in)
    {
        $this->_in = $in;
    }

    public function getIn()
    {
        return $this->_in;
    }

    public function setCurrency($currency)
    {
        $this->_currency = $currency;
    }

    public function getCurrency()
    {
        return $this->_currency;
    }
}
