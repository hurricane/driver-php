<?php

namespace Hurricane\Tests\Erlang\DataType;

use \Hurricane\Support\TestHelper;
use \Hurricane\Erlang\DataType\AtomCacheRef;

class AtomCacheRefTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Hurricane\Support\TestHelper
     */
    protected $helper;

    /**
     * @var \Hurricane\Erlang\DataType\AtomCacheRef
     */
    protected $subject;

    public function setUp()
    {
        $this->subject = new AtomCacheRef(10);
        $this->helper = new TestHelper($this->subject);
    }

    public function testClassShouldExist()
    {
        $this->helper->assertClassExists('\Hurricane\Erlang\DataType\AtomCacheRef');
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
            array('value', 10),
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
            array('value', 'int'),
        );
    }

    /**
     * @expectedException PHPUnit_Framework_Error
     */
    public function testValueShouldBeRequired()
    {
        new AtomCacheRef();
    }
}