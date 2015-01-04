<?php

/**
 * @file
 * Contains \Drupal\login_redirect\Form\PCPForm.
 */

namespace Drupal\login_redirect\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\field\FieldConfigInterface;

/**
 * Provides a Login Destination configuration form.
 */
class LoginRedirectForm extends ConfigFormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'login_redirect_configuration_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = \Drupal::config('login_redirect.configuration');

    $form['status'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Module Status'),
      '#options' => array('0' => $this->t('Disabled'), '1' => $this->t('Enabled')),
      '#default_value' => $config->get('status') ? $config->get('status') : 0,
      '#description' => $this->t('Should the module be enabled?'),
    );

    $form['parameter_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Parameter Name'),
      '#default_value' => $config->get('parameter_name') ? $config->get('parameter_name') : 'destination',
      '#description' => $this->t('Enter user defined query parameter name same as we have q in drupal core. For example if the parameter name is set to "destination", then you would visit user/login?destination=(redirect destination).'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = \Drupal::config('login_redirect.configuration');

    $config->set('status', $form_state->getValue('status'))
           ->set('parameter_name', $form_state->getValue('parameter_name'))
           ->save();

    parent::submitForm($form, $form_state);
  }

}
