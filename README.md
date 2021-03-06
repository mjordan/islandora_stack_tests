Islandora Stack Test Suite
==========================

Test suite for testing an Islandora stack after upgrades, configuration changes, etc.

Still just a proof of concept. Feedback, and more tests, are welcome. Please open an issue if you have either.

## Overview

This is a simple test suite to determine whether the main components of an Islandora stack (Drupal, Solr, and Fedora Commons) have become broken after an upgrade or major change in the configuration of any of the components. It is not intended as a replacement for functional or unit tests included with Drupal or Islandora modules. Its design goals are simplicity, ease of use, modularity, portability, and use of standard tools.

The suite contains four tests, one for each of Drupal, Fedora Commons, Solr, and a general speed test. However, these are intended more to be examples than definitive tests. You will likely want to add your own tests.

## Installation

The only prerequisite is a minimum PHP version of 5.4.0, which is required by the Guzzle HTTP client.

1. Clone this git repo.
2. Change into the resulting directory and install Composer by issuing the following command: ```curl -sS https://getcomposer.org/installer | php```

3. Use composer to install [PHPUnit](https://phpunit.de/) and [Guzzle](http://guzzle3.readthedocs.org/) by issuing the following command: ```php composer.phar install```

If you want to run your tests from a Windows machine, you should follow the [these instructions](https://getcomposer.org/doc/00-intro.md#installation-windows) to install Composer. Everything else should work as documented above.

## Usage

These tests can be run from any machine that meets the minimum PHP requirements, but it's probably a good idea to run them from somewhere other than your Drupal server (to avoid any false positives caused by running from 'localhost'). Change the settings in tests.ini to reflect your server's hostnames, etc. and run the test suite like this:

```
phpunit --log-tap=results.tap tests
```

Your rest results will be in results.tap:

```
TAP version 13
ok 1 - IslandoraDrupal::testDrupalIsReady
ok 2 - IslandoraDrupal::testForDrupalResponse
ok 3 - IslandoraFedora::testFedoraIsReady
ok 4 - IslandoraFedora::testForFedoraRindexResponse
ok 5 - IslandoraFedora::testForFedoraResponse
ok 6 - IslandoraSolr::testSolrIsReady
ok 7 - IslandoraSolr::testForSolrResponse
ok 8 - IslandoraSpeed::testTimeToDownloadCollectionPages
1..8
```

If any of your tests fail, you will see errors while running the tests, and your results file will document the failure. In this example, the Fedora server is not responding:

```
TAP version 13
ok 1 - IslandoraDrupal::testDrupalIsReady
ok 2 - IslandoraDrupal::testForDrupalResponse
not ok 3 - Error: IslandoraFedora::testFedoraIsReady
not ok 4 - Error: IslandoraFedora::testForFedoraRindexResponse
not ok 5 - Error: IslandoraFedora::testForFedoraResponse
ok 6 - IslandoraSolr::testSolrIsReady
ok 7 - IslandoraSolr::testForSolrResponse
not ok 8 - Error: IslandoraSpeed::testTimeToDownloadCollectionPages
1..8
```

If you want to use another log output format like JUnit XML or JSON, consult the PHPUnit [command-line options documentation](https://phpunit.de/manual/current/en/textui.html#textui.clioptions).

## Adding new tests

The easiest way to add new tests is to copy one of the files that exist in the /tests directory, change its name (which must follow the pattern the pattern "xxxTest.php"), and change the specifics inside the class definition. In particular, you will _need_ to change the class name (or PHP will throw a fatal error), and you _should_ change the function names since they they appear in the logged output. As long as your test files are in the /tests directory and follow that naming convention, PHPUnit will detect and run them automatically. You do not have to do anything else to get your tests to run.

Every test class should declare the ```protected $ini``` property and the ```public function setUp()``` method, since that is where the class reads the values from the tests.ini (or some other) configuration file. The names of functions in which the tests happen _must_ start with 'test'. The class file should also contain the 'require' and 'use' directives as illustrated below, if the tests employ the Guzzle HTTP client (and most tests will):

```php
<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

class IslandoraFoo extends PHPUnit_Framework_TestCase
{
    protected $ini;

    /**
     * You can use your own .ini file in your tests.
     * Names of functions that contain tests need to start with 'test'.
     */
    public function setUp()
    {
        $this->ini = parse_ini_file('tests.ini', TRUE);
    }

    public function testSomethingAboutFoo()
    {
        // Your test logic goes here.
    }

    public function testSomethingElseAboutFoo()
    {
        // Your test logic goes here.
    }
?>
```

If your new tests use configuration values, you can add the values to tests.ini or create your own .ini file and pass its path as an arguement to the ```parse_ini_file()``` function.

When writing your own tests, you will find the documentation on PHPUnit's [assertions](https://phpunit.de/manual/current/en/appendixes.assertions.html) and Guzzle's [Response objects](http://guzzle3.readthedocs.org/http-client/response.html) particularly useful. But, these tests are ordinary PHPUnit tests that use a Guzzle HTTP client to interact with various parts of the Islandora stack, so you can use any part of either framework that you need.
