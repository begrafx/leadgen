<?php
/**
 * @file
 * leadgen_core.features.defaultconfig.inc
 */

/**
 * Implements hook_defaultconfig_features().
 */
function leadgen_core_defaultconfig_features() {
  return array(
    'leadgen_core' => array(
      'strongarm' => 'strongarm',
    ),
  );
}

/**
 * Implements hook_defaultconfig_strongarm().
 */
function leadgen_core_defaultconfig_strongarm() {
  $export = array();

  $strongarm = new stdClass();
  $strongarm->disabled = FALSE; /* Edit this to true to make a default strongarm disabled initially */
  $strongarm->api_version = 1;
  $strongarm->name = 'admin_theme';
  $strongarm->value = 'seven';
  $export['admin_theme'] = $strongarm;

  return $export;
}
