<?php
namespace Drupal\node_redirector\Tests;
use Drupal\simpletest\WebTestBase;

/**
 * Tests the Node redirector module functionality
 */
class NodeRedirectBlockTest extends WebTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['block', 'node_redirector'];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    // Create and login user.
    $admin_user = $this->drupalCreateUser([
      'administer blocks', 'administer site configuration',
      'access administration pages',
    ]);
    $this->drupalLogin($admin_user);
  }

  /**
   * Tests the functionality of the block.
   */
  public function testBlock() {
    $assert = $this->assertSession();

    // Get the theme name.
    $theme = $this->config('system.theme')->get('default');
    
    // Check that block is listed to be added.
    $this->drupalGet('/admin/structure/block/library' . $theme, ['query' => ['region' => 'content']]);
    $assert->pageTextContains('Node Redirector Block');
    
    // Configure and save the block. 
    $parameters = [
      'label' => 'Node Redirector Block',
      'id' => 'node_redirector_block',
      'theme' => $theme,
    ]
    $this->drupalPlaceBlock('node_redirector', $parameters);

    // Ensure the block is placed.
    $this->drupalGet('');
    $assert->pageTextContains('Node Redirector', 'Enter Node ID');
    }

  }
