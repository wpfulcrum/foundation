<?php

namespace Fulcrum\Foundation\Tests\Unit;

if (version_compare(phpversion(), '5.6.0', '<')) {
    die('Whoops, PHP 5.6 or higher is required.');
}

define('FULCRUM_FOUNDATION_TESTS_DIR', __DIR__);
define('FULCRUM_FOUNDATION_ROOT_DIR', dirname(dirname(FULCRUM_FOUNDATION_TESTS_DIR)) . DIRECTORY_SEPARATOR);

require_once FULCRUM_FOUNDATION_TESTS_DIR . DIRECTORY_SEPARATOR .'FulcrumTestCase.php';

/**
 * Time to load Composer's autoloader.
 */
$vendorPath = FULCRUM_FOUNDATION_ROOT_DIR . 'vendor' . DIRECTORY_SEPARATOR;
if (!file_exists($vendorPath . 'autoload.php')) {
    die('Whoops, we need Composer before we start running tests.  Please type: `composer install`.');
}
require_once $vendorPath . 'autoload.php';
unset($vendorPath);
