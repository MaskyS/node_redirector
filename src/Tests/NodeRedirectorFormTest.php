<?php

namespace Drupal\node_redirector\Tests;

use Drupal\Core\Url;
use Drupal\simpletest\BrowserTestBase;

/**
 * Provide tests for the NodeRedirectorForm form.
 * @group node_redirector
 */
class NodeRedirectorFormTest extends BrowserTestBase {

  /**
   * Modules to install.
   *
   * @var array
   */
  public static $modules = ['node', 'node_redirector'];

  /**
   * Tests that the all components of the form are present.
   */
  public function testNodeRedirectorFormExists() {
    // Check if a page exists on /node-redirector-form.
    $this->drupalGet('node-redirector-form');
    $this->assertResponse(200, 'URL is accessible to anonymous user.');

    // Test that the text field exists.
    $this->assertFieldByName('node', NULL, 'Node textfield is present.');

    // Test that the submit button exists.
    $this->assertFieldById('edit-submit', "Let's go!", 'Submit button is ok.');
  }

  /**
   * Test the submission of the form.
   *
   * @throws \Exception
   */
  public function testNodeRedirectFormSubmit() {

    // Submit the form with a node ID number less than 0.
    $this->drupalPostForm(
    'node-redirector-form', ['node' => '0'], t("Let's go!")
    );
    $this->assertText("Be positive! I'm sure you know a number more than 0");

    // Submit the form with a decimal.
    $this->drupalPostForm(
    'node-redirector-form', ['node' => '69.0'], t("Let's go!")
    );
    $this->assertText('In the future, Node IDs will support so you can use 3.14159265359 as URL for your science page, but until then, please enter an integer.');

    // Submit the form with a non-numeric value.
    $this->drupalPostForm(
    'node-redirector-form', ['node' => '1234abcd'], t("Let's go!")
    );
    $this->assertText('Please enter a number; Node IDs are numeric.');

    // Submit the form with valid node ID which should pass.
    $this->drupalPostForm(
    'node-redirector-form', ['node' => '1'], t("Let's go!")
    );

    // We should now be on the node page, and see the right form success
    // message.
    $this->assertUrl('node/1');
  }

}
