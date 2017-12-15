<?php

namespace Drupal\node_redirector\Plugin\Block;
use Drupal\Core\Block\BlockBase;

/**
 * Provides the 'Node Redirector' Block
 *
 * @Block(
 *   id = "node_redirector",
 *   admin_label = @Translation("Node Redirector Block"),
 * )
 */
class NodeRedirectorBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {
    $builtForm = \Drupal::formBuilder()->getForm('Drupal\node_redirector\Form\NodeRedirectorForm');
    $renderArray['form'] = $builtForm;
    return $renderArray;
  }
}

