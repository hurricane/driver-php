<?php

namespace Hurricane\Tests\Erlang\DataType;

use \Hurricane\Erlang\DataType\Atom;

class AtomTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Hurricane\Erlang\DataType\Atom
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = new Atom('bob');
    }

    public function testClassShouldExist()
    {
        $class = '\Hurricane\Erlang\DataType\Atom';
        $this->assertTrue(class_exists($class));
        $this->assertInstanceOf($class, $this->subject);
    }

    public function testNameShouldBeSettableAndGettable()
    {
        $name = 'hurricane';
        $this->subject->setName($name);
        $this->assertEquals($name, $this->subject->getName());
    }

    public function testNameShouldBeCastToString()
    {
        $this->subject->setName('test');
        $this->assertTrue(is_string($this->subject->getName()));

        $this->subject->setName(10);
        $this->assertTrue(is_string($this->subject->getName()));

        $this->subject->setName(true);
        $this->assertTrue(is_string($this->subject->getName()));
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testNameShouldBeRequired()
    {
        new Atom();
    }
}