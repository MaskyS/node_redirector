<?php

namespace Drupal\node_redirector\Form;

use Drupal\Core\Url;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Implements the Node Redirector form.
 */
class NodeRedirectorForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'node_redirector';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['node'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Enter Node ID'),
      '#required' => TRUE,
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t("Let's go!"),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $node = $form_state->getValue('node');
    if ($node < 1) {
      $form_state->setErrorByName('node', $this->t("Be positive! I'm sure you know a number more than 0"));
    }
    if (!is_numeric($node)) {
      $form_state->setErrorByName('node', $this->t('Please enter a number; Node IDs are numeric.'));
    }
    if (is_float($node) || strpos($node, ".")) {
      $form_state->setErrorByName('node', $this->t('In the future, Node IDs will support so you can use 3.14159265359 as URL for your science page, but until then, please enter an integer.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $options = ['absolute' => TRUE];
    $url = Url::fromRoute('entity.node.canonical', ['node' => $form_state->getValue('node')], $options)->toString();
    $response = new RedirectResponse($url);
    $response->send();
  }

}
