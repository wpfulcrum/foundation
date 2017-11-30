<?php

namespace Fulcrum\Foundation\Tests\Stubs;

use Fulcrum\Foundation\ServiceProvider\Provider;

class FooProviderStub extends Provider
{
    protected $hasDefaults = true;
    protected $defaultsLocation = 'fixtures/foo-defaults.php';

    public function register(array $concreteConfig, $uniqueId)
    {
        // nothing here
    }

    public function getConcrete(array $config, $uniqueId = '')
    {
        // nothing here
    }

    protected function getConcreteDefaultStructure()
    {
        return [
            'autoload' => false,
            'config'   => '',
            'foobar'   => [
                'bar' => 'baz',
            ],
        ];
    }
}
