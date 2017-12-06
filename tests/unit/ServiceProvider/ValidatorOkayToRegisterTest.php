<?php

namespace Fulcrum\Foundation\Tests\Unit\ServiceProvider;

use Brain\Monkey\Functions;
use Fulcrum\Foundation\ServiceProvider\Validator;
use Fulcrum\Foundation\Tests\Unit\FulcrumTestCase;

class ValidatorOkayToRegisterTest extends FulcrumTestCase
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
