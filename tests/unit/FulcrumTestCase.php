<?php

namespace Fulcrum\Foundation\Tests\Unit;

use Brain\Monkey;
use PHPUnit\Framework\TestCase;

abstract class FulcrumTestCase extends TestCase
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
    }
}
