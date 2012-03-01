<?php

namespace Hurricane\Tests\Erlang\DataType;

use \Hurricane\Support\TestHelper;
use \Hurricane\Erlang\DataType\Atom;

class AtomTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Hurricane\Erlang\DataType\Atom
     */
    protected $subject;

    /**
     * @var \Hurricane\Support\TestHelper
     */
    protected $helper;

    public function setUp()
    {
        $this->subject = new Atom('bob');
        $this->helper = new TestHelper($this->subject);
    }

    public function testClassShouldExist()
    {
        $this->helper->assertClassExists('\Hurricane\Erlang\DataType\Atom');
    }

    /**
     * @dataProvider propertiesProvider
     * @param $property
     * @param $value
     */
    public function testShouldSetAndGet($property, $value)
    {
        $this->helper->assertSetAndGet($property, $value);
    }

    public function propertiesProvider()
    {
        return array(
            array('name', 'hurricane'),
        );
    }

    /**
     * @dataProvider propertiesCastProvider
     * @param $property
     * @param $type
     */
    public function testShouldCast($property, $type)
    {
        $this->helper->assertCastCorrectly($property, $type);
    }

    public function propertiesCastProvider()
    {
        return array(
            array('name', 'string'),
        );
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testNameShouldBeRequired()
    {
        new Atom();
    }
}