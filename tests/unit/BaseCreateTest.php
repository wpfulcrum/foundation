<?php

namespace Fulcrum\Foundation\Tests\Unit;

use Brain\Monkey\Functions;
use Fulcrum\Config\ConfigFactory;
use Fulcrum\Config\Exception\InvalidFileException;
use Fulcrum\Foundation\Tests\Unit\Stubs\BadProviderStub;
use Fulcrum\Foundation\Tests\Unit\Stubs\FooBaseStub;
use Fulcrum\Foundation\Tests\Unit\Stubs\FooProviderStub;
use Mockery;

class BaseCreateTest extends FulcrumTestCase
{
    protected $fulcrumMock;

    protected function setUp()
    {
        parent::setUp();
        $this->fulcrumMock = Mockery::mock('Fulcrum\FulcrumContract');
    }

    public function testShouldCreate()
    {
        $config = ConfigFactory::create([
           'foo' => 'bar',
        ]);
        $stub = new FooBaseStub($config, $this->fulcrumMock);
        $this->assertInstanceOf(FooBaseStub::class, $stub);
        $this->assertEquals($config, $stub->get('config'));
    }

    public function testShouldReturnDefaultWhenPropertyDoesNotExist()
    {
        $config = ConfigFactory::create([
            'foo' => 'bar',
        ]);
        $stub = new FooBaseStub($config, $this->fulcrumMock);
        $this->assertNull($stub->get('donotexistsilly'));
        $this->assertFalse($stub->get('donotexistsilly', false));
    }

    public function testConfigHas()
    {
        $config = ConfigFactory::create([
            'foo' => 'bar',
        ]);
        $stub = new FooBaseStub($config, $this->fulcrumMock);
        $this->assertTrue($stub->configHas('foo'));
        $this->assertFalse($stub->configHas('bar'));
        $this->assertFalse($stub->configHas('foobar'));
    }

    public function testGetDefaultsFileWhenNoDefaultFileSpecified()
    {
        $config = ConfigFactory::create([
            'foo' => 'bar',
        ]);
        $stub = new FooBaseStub($config, $this->fulcrumMock);
        $this->assertSame(__DIR__ . '/unitfoobasestub.php', $stub::getDefaultsFile(__DIR__));
    }
}
