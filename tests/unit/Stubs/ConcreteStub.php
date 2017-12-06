<?php

namespace Fulcrum\Foundation\Tests\Unit\Stubs;

use Fulcrum\Config\ConfigContract;

class ConcreteStub
{
    public $config;

    public function __construct(ConfigContract $config)
    {
        $this->config = $config;
    }
}
