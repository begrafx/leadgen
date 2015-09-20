<?php

/**
 * @file
 * Enables modules and site configuration for LeadGen site installation.
 */

/**
 * Implements hook_install_tasks_alter()
 */
function leadgen_install_tasks_alter(&$tasks, $install_state) {

  // Magically go one level deeper in solving years of dependency problems
  require_once(drupal_get_path('module', 'panopoly_core') . '/panopoly_core.profile.inc');
  $tasks['install_load_profile']['function'] = 'panopoly_core_install_load_profile';

  // If we only offer one language, define a callback to set this
  require_once(drupal_get_path('module', 'panopoly_core') . '/panopoly_core.profile.inc');
  if (!(count(install_find_locales($install_state['parameters']['profile'])) > 1)) {
    $tasks['install_select_locale']['function'] = 'panopoly_core_install_locale_selection';
  }
}
