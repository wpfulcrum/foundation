<?php

namespace Fulcrum\Foundation\Tests;

use Brain\Monkey\Functions;
use Fulcrum\Foundation\ServiceProvider\Validator;

class ValidatorOkayToRegisterTest extends TestCase
{
    protected static $defaultStructure = [
        'autoload' => false,
        'config'   => '',
    ];

    public function testShouldReturnTrue()
    {
        Functions\when('__')->justReturn('');
        $concreteConfig = [
            'autoload' => false,
            'config'   => [
                'foo' => true,
            ],
        ];

        $this->assertTrue(
            Validator::okayToRegister(
                'foo',
                $concreteConfig,
                self::$defaultStructure,
                __CLASS__
            )
        );
    }
}
