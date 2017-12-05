<?php

namespace Fulcrum\Foundation\Tests\Stubs;

use Fulcrum\Config\ConfigContract;

class ConcreteStub
{
    public $config;

    public function __construct(ConfigContract $config)
    {
        $this->config = $config;
    }
}