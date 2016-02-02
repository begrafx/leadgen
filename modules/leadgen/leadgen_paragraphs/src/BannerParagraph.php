<?php

/**
 * @file
 * Contains \Drupal\leadgen_paragraphs\BannerParagraph.
 */

namespace Drupal\leadgen_paragraphs;

use Drupal\image\Entity\ImageStyle;

/**
 * Renders a banner paragraph.
 */
class BannerParagraph implements ParagraphRendererInterface {

  /**
   * {@inheritdoc}
   */
  public function render(array &$variables) {
    $paragraph = $variables['paragraph'];

    // If banner image and nested paragraphs are present.
    if (!$paragraph->field_image->isEmpty() && !$paragraph->field_paragraphs->isEmpty()) {
      // Get banner image.
      $banner_image_uri = $paragraph->field_image->entity->getFileUri();
      $banner_image = ImageStyle::load('banner')->buildUrl($banner_image_uri);
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
