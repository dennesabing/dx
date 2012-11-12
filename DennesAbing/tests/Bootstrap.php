<?php
/**
 * Dx Library for Zend Framework 2 (http://framework.zend.com/)
 *
 * @link      http://github.com/dennesabing/dx for the canonical source repository
 * @package   Dx
 */

/*
 * Set error reporting to the level to which Zend Framework code must comply.
 */
error_reporting( E_ALL | E_STRICT );


if (class_exists('PHPUnit_Runner_Version', true)) {
    $phpUnitVersion = PHPUnit_Runner_Version::id();
    if ('@package_version@' !== $phpUnitVersion && version_compare($phpUnitVersion, '3.6.0', '<')) {
        echo 'This version of PHPUnit (' . PHPUnit_Runner_Version::id() . ') is not supported in Zend Framework 2.x unit tests.' . PHP_EOL;
        exit(1);
    }
    unset($phpUnitVersion);
}

/*
 * Determine the root, library, and tests directories of the library
 * distribution.
 */
$dxRoot        = realpath(dirname(__DIR__));
$dxCoreLibrary   = "$dxRoot/library";
$dxCoreTests   = "$dxRoot/tests";

/*
 * Prepend the Dx library/ and tests/ directories to the
 * include_path. This allows the tests to run out of the box and helps prevent
 * loading other copies of the framework code and tests that would supersede
 * this copy.
 */
$path = array(
    $dxCoreLibrary,
    $dxCoreTests,
    get_include_path(),
);
set_include_path(implode(PATH_SEPARATOR, $path));

/**
 * Setup autoloading
 */
include __DIR__ . '/_autoload.php';

/*
 * Load the user-defined test configuration file, if it exists; otherwise, load
 * the default configuration.
 */
if (is_readable($dxCoreTests . DIRECTORY_SEPARATOR . 'TestConfiguration.php')) {
    require_once $dxCoreTests . DIRECTORY_SEPARATOR . 'TestConfiguration.php';
} else {
    require_once $dxCoreTests . DIRECTORY_SEPARATOR . 'TestConfiguration.php.dist';
}

if (defined('TESTS_GENERATE_REPORT') && TESTS_GENERATE_REPORT === true) {
    $codeCoverageFilter = new PHP_CodeCoverage_Filter();

    $lastArg = end($_SERVER['argv']);
    if (is_dir($dxCoreTests . '/' . $lastArg)) {
        $codeCoverageFilter->addDirectoryToWhitelist($dxCoreLibrary . '/' . $lastArg);
    } elseif (is_file($dxCoreTests . '/' . $lastArg)) {
        $codeCoverageFilter->addDirectoryToWhitelist(dirname($dxCoreLibrary . '/' . $lastArg));
    } else {
        $codeCoverageFilter->addDirectoryToWhitelist($dxCoreLibrary);
    }

    /*
     * Omit from code coverage reports the contents of the tests directory
     */
    $codeCoverageFilter->addDirectoryToBlacklist($dxCoreTests, '');
    $codeCoverageFilter->addDirectoryToBlacklist(PEAR_INSTALL_DIR, '');
    $codeCoverageFilter->addDirectoryToBlacklist(PHP_LIBDIR, '');

    unset($codeCoverageFilter);
}


/**
 * Start output buffering, if enabled
 */
if (defined('TESTS_DX_OB_ENABLED') && constant('TESTS_DX_OB_ENABLED')) {
    ob_start();
}

/*
 * Unset global variables that are no longer needed.
 */
unset($dxRoot, $zfCoreLibrary, $dxCoreTests, $path);
