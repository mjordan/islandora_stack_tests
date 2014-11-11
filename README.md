Islandora Stack Test Suite
==========================

Test suite for testing an Islandora stack after upgrades, configuration changes, etc.

Still just a proof of concept.

## Overview

This is a test suite to determine whether the main components of an Islandora stack (Drupal, Solr, and Fedora Commons) have become broken after an upgrade or major change in the configuration of any of the components. It is not intended as a replacement for functional or unit tests included with Drupal or Islandora modules.

## Installation

1. Clone this git repo.
2. CD into the resulting directory and install composer by issuing the following command: ```curl -sS https://getcomposer.org/installer | php```

3. Use composer to install [PHPUnit](https://phpunit.de/) and [Guzzle](http://guzzle3.readthedocs.org/): ```php composer.phar install```

## Usage

Change the settings in tests.ini and run like this:

```
phpunit --log-tap=results.tap tests
```

Your rest results will be in results.tap.
