#!/bin/bash
# Use proxy (e.g. squid) to speed up regular builds
rm -rf modules/contrib
rm -rf modules/panopoly
rm -rf themes/contrib
drush make --no-core --contrib-destination=. drupal-org.make .
# Usually run update.php and clear the cache here