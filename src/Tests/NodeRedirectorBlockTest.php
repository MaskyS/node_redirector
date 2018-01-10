<?php

namespace Drupal\node_redirector\Tests;

use Drupal\Component\Utility\Unicode;
use Drupal\simpletest\BrowserTestBase;

/**
 * Tests the Node Redirector block.
 * @group node_redirector
 */
class NodeRedirectorBlockTest extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['block', 'node_redirector'];

  /**
   * Tests the functionality of the block.
   */
  public function testBlock() {
    $assert = $this->assertSession();

    // Create user.
    $web_user = $this->drupalCreateUser(['administer blocks']);
    // Login the admin user.
    $this->drupalLogin($web_user);

    // Get the theme name.
    $theme = $this->config('system.theme')->get('default');

    // Check that block is listed to be added.
    $this->drupalGet('/admin/structure/block/library/' . $theme, ['query' => ['region' => 'content']]);
    $assert->pageTextContains('Node Redirector Block');

    // Configure and save the block.
    $parameters = [
      'label' => 'Node Redirector Block',
      'id' => 'node_redirector_block',
      'theme' => $theme,
    ];
    $this->drupalPlaceBlock('node_redirector', $parameters);

    // Ensure the block is placed.
    $this->drupalGet('');
    $assert->pageTextContains('Node Redirector', 'Enter Node ID');
  }

}
