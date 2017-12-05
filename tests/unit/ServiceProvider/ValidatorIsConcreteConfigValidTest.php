<?php

namespace Fulcrum\Foundation\Tests;

use Brain\Monkey\Functions;
use Fulcrum\Config\Exception\InvalidSourceException;
use Fulcrum\Foundation\Exception\MissingRequiredParameterException;
use Fulcrum\Foundation\ServiceProvider\Validator;

class ValidatorIsConcreteConfigValidTest extends TestCase
{
    protected static $defaultStructure = [
        'autoload' => false,
        'config'   => '',
    ];

    public function testShouldThrowErrorWhenMissingConfigParam()
    {
        Functions\when('__')
            ->justReturn("The required %s parameter is missing in the service provider's configuration for unique ID [%s]. [Class %s]"); // @codingStandardsIgnoreLine - Generic.Files.LineLength.TooLong

        $expected = [
            'foo'    => [
                'missingParameter' => 'autoload',
                'concreteConfig'   => [
                    'config' => '',
                ],
            ],
            'foobar' => [
                'missingParameter' => 'config',
                'concreteConfig'   => [
                    'autoload' => false,
                ],
            ],
        ];

        foreach ($expected as $uniqueId => $params) {
            try {
                Validator::isConcreteConfigValid(
                    $uniqueId,
                    $params['concreteConfig'],
                    self::$defaultStructure,
                    __CLASS__
                );
            } catch (MissingRequiredParameterException $exception) {
                $errorMessage = sprintf(
                    "The required %s parameter is missing in the service provider's configuration for unique ID [%s]. [Class %s]", // @codingStandardsIgnoreLine - Generic.Files.LineLength.TooLong
                    $uniqueId,
                    $params['missingParameter'],
                    __CLASS__
                );

                $this->assertSame($errorMessage, $exception->getMessage());
            }
        }
    }

    public function testShouldThrowErrorWhenConfigEmptyString()
    {
        Functions\when('__')
            ->justReturn('The configuration source for unique ID [%s] cannot be empty. [Service Provider: %s]');
        $expected = [
            'foo' => [
                'autoload' => false,
                'config'   => '',
            ],
            'bar' => [
                'autoload' => false,
                'config'   => null,
            ],
            'baz' => [
                'autoload' => false,
                'config'   => [],
            ],
        ];

        foreach ($expected as $uniqueId => $concreteConfig) {
            try {
                Validator::isConcreteConfigValid(
                    $uniqueId,
                    $concreteConfig,
                    self::$defaultStructure,
                    __CLASS__
                );
            } catch (InvalidSourceException $exception) {
                $errorMessage = sprintf(
                    'The configuration source for unique ID [%s] cannot be empty. [Service Provider: %s]: %s',
                    $uniqueId,
                    __CLASS__,
                    print_r($concreteConfig['config'], true)
                );

                $this->assertSame($errorMessage, $exception->getMessage());
            }
        }
    }
}
