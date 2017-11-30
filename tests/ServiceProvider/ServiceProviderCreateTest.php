<?php

namespace Fulcrum\Foundation\Tests;

use Brain\Monkey\Functions;
use Fulcrum\Foundation\Tests\Stubs\BadProviderStub;
use Fulcrum\Foundation\Tests\Stubs\FooProviderStub;
use Mockery;

class ServiceProviderCreateTest extends TestCase
{
    protected $fulcrumMock;

    protected function setUp()
    {
        parent::setUp();
        $this->fulcrumMock = Mockery::mock('Fulcrum\FulcrumContract');
    }

    public function testShouldCreate()
    {
        $stub = new FooProviderStub($this->fulcrumMock);
        $this->assertInstanceOf(FooProviderStub::class, $stub);
    }

    public function testShouldOverrideConcreteDefaultStructure()
    {
        $stub = new FooProviderStub($this->fulcrumMock);

        $this->assertEquals([
            'autoload' => false,
            'config'   => '',
            'foobar'   => [
                'bar' => 'baz',
            ],
        ], $stub->defaultStructure);
    }

    public function testShouldLoadDefault()
    {
        $stub = new FooProviderStub($this->fulcrumMock);
        $path = FULCRUM_FOUNDATION_TESTS_DIR . '/Stubs/fixtures/foo-defaults.php';

        $this->assertEquals($path, $stub->defaultsLocation);
        $this->assertEquals([
            'foo'       => [],
            'bar'       => [],
            'baz'       => [],
            'isEnabled' => false,
        ], $stub->defaults);
    }

    public function testShouldThrowError()
    {
        $errorMessage = 'The specified defaults config file is not readable.';
        Functions\when('__')
            ->justEcho($errorMessage);

        $this->expectException(\RuntimeException::class);
        $this->expectOutputString($errorMessage);

        new BadProviderStub($this->fulcrumMock);
    }
}
