<?php

/**
 * @file
 * Contains \Drupal\leadgen_paragraphs\BannerParagraph.
 */

namespace Drupal\leadgen_paragraphs;

use Drupal\image\Entity\ImageStyle;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Renders a banner paragraph.
 */
class BannerParagraph implements ParagraphRendererInterface {

  /**
   * The aggregator.settings config object.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $config;

  /**
   * Constructs an BannerParagraph object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The factory for configuration objects.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->config = $config_factory->get('leadgen_paragraphs.banner_settings');
  }

  /**
   * {@inheritdoc}
   */
  public function render(array &$variables) {
    $paragraph = $variables['paragraph'];

    // If banner image and nested paragraphs are present.
    if (!$paragraph->field_image->isEmpty() && !$paragraph->field_paragraphs->isEmpty()) {
      $image_style = $this->config->get('image_style');
      // Generate image URL.
      if (!empty($image_style)) {
        $banner_image_uri = $paragraph->field_image->entity->getFileUri();
        $banner_image = ImageStyle::load($image_style)->buildUrl($banner_image_uri);
      }
      else {
        $banner_image = $paragraph->field_image->entity->url();
      }
      // Add image as background.
      $variables['attributes']['style'][] = 'background-image: url("' . $banner_image . '");';
      $variables['attributes']['style'][] = 'background-size: cover;background-position: center center;';
      // Hide the normal <img> tag.
      hide($variables['content']['field_image']);
    }
    // Check if banner color is empty.
    if (!$paragraph->field_banner_color->isEmpty()) {
      $banner_color = $paragraph->field_banner_color->getValue();
      $banner_color = reset($banner_color);
      $variables['attributes']['style'][] = 'background: ' . $banner_color['color'] . ';';
    }

    // Check if text color is empty.
    if (!$paragraph->field_text_color->isEmpty()) {
      $text_color = $paragraph->field_text_color->getValue();
      $text_color = reset($text_color);
      $variables['attributes']['style'][] = 'color: ' . $text_color['color'] . ';';
    }

    if (!$paragraph->field_paragraphs->isEmpty()) {
      $paragraphs = $paragraph->field_paragraphs->referencedEntities();
      if (count($paragraphs) == 1) {
        $variables['attributes']['class'][] = 'paragraph--single-nested';
      }
      else {
        $variables['attributes']['class'][] = 'paragraph--multiple-nested';
      }
    }
  }
}
