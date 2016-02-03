<?php

/**
 * @file
 * Contains Drupal\leadgen_paragraphs\Form\BannerSettingsForm.
 */

namespace Drupal\leadgen_paragraphs\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class BannerSettingsForm.
 *
 * @package Drupal\leadgen_paragraphs\Form
 */
class BannerSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'leadgen_paragraphs.banner_settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'leadgen_paragraphs_banner_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $banner_config = $this->config('leadgen_paragraphs.banner_settings');
    $image_styles = image_style_options(FALSE);
    $form['image_style'] = [
      '#title' => t('Image style'),
      '#type' => 'select',
      '#default_value' => $banner_config->get('image_style'),
      '#empty_option' => t('None (original image)'),
      '#options' => $image_styles,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('leadgen_paragraphs.banner_settings')
      ->set('image_style', $form_state->getValue('image_style'))
      ->save();
  }
}
