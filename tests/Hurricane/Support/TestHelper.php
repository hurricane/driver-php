<?php

namespace Hurricane\Support;

class TestHelper extends \PHPUnit_Framework_TestCase
{
    /**
     * @var mixed
     */
    protected $subject;

    /**
     * @param $subject
     */
    public function __construct($subject)
    {
        $this->subject = $subject;
    }

    public function assertClassExists($class)
    {
        $this->assertTrue(class_exists($class));
        $this->assertInstanceOf($class, $this->subject);
    }

    /**
     * testing that a property goes inside a setter
     * and comes out a getter the same
     *
     * @param string $property
     * @param mixed $value
     */
    public function assertSetAndGet($property, $value)
    {
        $property = (string) $property;
        $setter = 'set' . ucfirst($property);
        $getter = 'get' . ucfirst($property);

        $this->assertTrue(method_exists($this->subject, $setter));
        $this->assertTrue(method_exists($this->subject, $getter));

        $this->subject->{$setter}($value);
        $gotten = $this->subject->{$getter}();
        $this->assertEquals($value, $gotten);
    }

    /**
     * make sure that property is properly cast
     *
     * @param $property
     * @param $type
     */
    public function assertCastCorrectly($property, $type)
    {
        $values = array(1, 0, true, array(), 'test');

        $property = (string) $property;
        $type = (string) $type;
        $setter = 'set' . ucfirst($property);
        $getter = 'get' . ucfirst($property);

        $this->assertTrue(method_exists($this->subject, $setter));
        $this->assertTrue(method_exists($this->subject, $getter));

        foreach($values as $v){

            $this->subject->{$setter}($v);
            $value = $this->subject->{$getter}();

            switch($type) {
                case 'string':
                    $this->assertTrue(is_string($value));
                    break;
                case 'int':
                    $this->assertTrue(is_int($value));
                    break;
            }
        }
    }
}