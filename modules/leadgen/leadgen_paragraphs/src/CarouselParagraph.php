<?php

/**
 * @file
 * Contains \Drupal\leadgen_paragraphs\CarouselParagraph.
 */

namespace Drupal\leadgen_paragraphs;

use Drupal\image\Entity\ImageStyle;

/**
 * Renders a Carousel paragraph.
 */
class CarouselParagraph implements ParagraphRendererInterface {

  /**
   * {@inheritdoc}
   */
  public function render(array &$variables) {
    $slides = [];

    $paragraph = $variables['paragraph'];
    if (!$paragraph->field_paragraphs->isEmpty()) {
      $paragraphs = $paragraph->field_paragraphs->referencedEntities();
      foreach ($paragraphs as $slide_paragraph) {

        $item = [];
        if (!$slide_paragraph->field_title->isEmpty()) {
          $item['title'] = $slide_paragraph->field_title->value;
        }
        if (!$slide_paragraph->field_text->isEmpty()) {
          $item['description'] = [
            '#markup' => $slide_paragraph->field_text->value,
          ];
        }

        if (!$slide_paragraph->field_image->isEmpty()) {
          $image_uri = $slide_paragraph->field_image->entity->getFileUri();
          $image = ImageStyle::load('banner')->buildUrl($image_uri);
          // TODO Should use the theme_image or whatever it's called in D8.
          $item['image'] = [
            '#markup' => '<img src="' . $image . '" class="img-responsive center-block" />',
          ];
        }

        if (!empty($item)) {
          $slides[] = $item;
        }
      }
    }

    if(!empty($slides)) {
      $variables['content']['bootstrap_carousel'] = [
        '#theme' => 'bootstrap_carousel',
        '#slides' => $slides,
      ];
      hide($variables['content']['field_paragraphs']);
    }
  }
}
