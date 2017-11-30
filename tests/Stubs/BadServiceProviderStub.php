<?php

namespace Fulcrum\Foundation\Tests\Stubs;

use Fulcrum\Foundation\ServiceProvider\Provider;

class BadProviderStub extends Provider
{
    protected $hasDefaults = true;
    protected $defaultsLocation = 'doesnotexist/bad-filename.php';

    public function register(array $concreteConfig, $uniqueId)
    {
        // nothing here
    }

    public function getConcrete(array $config, $uniqueId = '')
    {
        // nothing here
    }
}
