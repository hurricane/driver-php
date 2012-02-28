<?php

namespace Hurricane\Tests;

use Hurricane\Gateway;

class GatewayTest extends \PHPUnit_Framework_TestCase
{
    protected $subject;

    public function setUp()
    {
        $this->subject = new Gateway();
    }

    public function testClassShouldExist()
    {
        $this->assertTrue(class_exists('\Hurricane\Gateway'));
    }
}