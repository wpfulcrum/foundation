<?php

namespace Fulcrum\Foundation\Tests;

use Brain\Monkey;
use Mockery;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected $isLoaded = false;
    protected $testArrayPath;
    protected $defaultsPath;
    protected $testArray;
    protected $defaults;

    /**
     * Prepares the test environment before each test.
     */
    protected function setUp()
    {
        parent::setUp();
        Monkey\setUp();
    }

    /**
     * Cleans up the test environment after each test.
     */
    protected function tearDown()
    {
        Monkey\tearDown();
        parent::tearDown();
        Mockery::close();
    }
}
