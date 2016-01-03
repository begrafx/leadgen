<?php
/**
 * @file
 * Contains \Drupal\leadgen_layouts\Tests\LeadGenLayoutsTest.php.
 */

namespace Drupal\leadgen_layouts\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Tests the leadgen_layouts_test module.
 *
 * @group leadgen_layouts
 */
class LeadGenLayoutsTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'leadgen_layouts',
    'ds',
    'layout_plugin',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $admin_user = $this->drupalCreateUser(array(
      'admin classes',
      'admin display suite'
    ));
    $this->drupalLogin($admin_user);
  }

  /**
   * Test default region classes appear.
   */
  public function testCustomDisplaySuiteRegionClasses() {
    $this->drupalGet('admin/structure/ds/classes');
    $this->assertRaw('dynamic-container', 'Dynamic container class found');
    $this->assertRaw('paragraph', 'Paragraph class found');
  }
}