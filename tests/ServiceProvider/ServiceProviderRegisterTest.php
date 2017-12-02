<?php

namespace Fulcrum\Foundation\Tests;

use Brain\Monkey\Functions;
use Fulcrum\Config\Exception\InvalidFileException;
use Fulcrum\Foundation\Tests\Stubs\BadProviderStub;
use Fulcrum\Foundation\Tests\Stubs\FooProviderStub;
use Mockery;

class ServiceProviderRegisterTest extends TestCase
{
    protected $fulcrumMock;

    protected function setUp()
    {
        parent::setUp();
        $this->fulcrumMock = Mockery::mock('Fulcrum\FulcrumContract');
    }

    public function testShouldCreate()
    {
        Functions\when('__')->justReturn('');
        $stub = new FooProviderStub($this->fulcrumMock);
        $this->assertInstanceOf(FooProviderStub::class, $stub);
    }

    public function testShouldOverrideConcreteDefaultStructure()
    {
        Functions\when('__')->justReturn('');
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
        Functions\when('__')->justReturn('');
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
}
