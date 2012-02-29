<?php

namespace Hurricane\Tests\Erlang\DataType;

use \Hurricane\Erlang\DataType\AtomCacheRef;

class AtomCacheRefTest extends \PHPUnit_Framework_TestCase
{
    protected $subject;

    public function setUp()
    {
        $this->subject = new AtomCacheRef(10);
    }

    public function testClassShouldExist()
    {
        $class = '\Hurricane\Erlang\DataType\AtomCacheRef';
        $this->assertTrue(class_exists($class));
        $this->assertInstanceOf($class, $this->subject);
    }

    public function testValueShouldBeSettableAndGettable()
    {
        $value = 10;
        $this->subject->setValue($value);
        $this->assertEquals($value, $this->subject->getValue());
    }

    public function testNameShouldBeCastToInt()
    {
        $this->subject->setValue(10);
        $this->assertTrue(is_int($this->subject->getValue()));

        $this->subject->setValue('test');
        $this->assertTrue(is_int($this->subject->getValue()));

        $this->subject->setValue(true);
        $this->assertTrue(is_int($this->subject->getValue()));

        $this->subject->setValue(array());
        $this->assertTrue(is_int($this->subject->getValue()));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testValueShouldBeRequired()
    {
        new AtomCacheRef();
    }
}