Islandora Stack Test Suite
==========================

Test suite for testing an Islandora stack after upgrades, configuration changes, etc.

Still just a proof of concept.

## Overview

This is a test suite to determine whether the main components of an Islandora stack (Drupal, Solr, and Fedora Commons) have become broken after an upgrade or major change in the configuration of any of the components. It is not intended as a replacement for functional or unit tests included with Drupal or Islandora modules.

## Installation

1. Clone this git repo.
2. Change into the resulting directory and install composer by issuing the following command: ```curl -sS https://getcomposer.org/installer | php```

3. Use composer to install [PHPUnit](https://phpunit.de/) and [Guzzle](http://guzzle3.readthedocs.org/) by issuing the following command: ```php composer.phar install```

## Usage

Change the settings in tests.ini to reflect your hostnames, etc. and run the test suite like this:

```
phpunit --log-tap=results.tap tests
```

Your rest results will be in results.tap:

```
TAP version 13
ok 1 - IslandoraDrupal::testDrupalIsReady
ok 2 - IslandoraDrupal::testForDrupalResponse
ok 3 - IslandoraFedora::testFedoraIsReady
ok 4 - IslandoraFedora::testForFedoraResponse
ok 5 - IslandoraSolr::testSolrIsReady
ok 6 - IslandoraSolr::testForSolrResponse
1..6
```

If you want to use another log output format, consult the PHPUnit [command-line options' documentation](https://phpunit.de/manual/current/en/textui.html#textui.clioptions).
