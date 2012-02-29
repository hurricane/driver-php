<?php

namespace Hurricane\Tests\Erlang\DataType;

use \Hurricane\Erlang\DataType\Atom;

class AtomTest extends \PHPUnit_Framework_TestCase
{
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
        $name = 'bob';
        $this->subject->setName($name);
        $this->assertEquals($name, $this->subject->getName());
    }
}