<?php

/**
 * @file
 * Contains \Drupal\leadgen_paragraphs\CarouselParagraph.
 */

namespace Drupal\leadgen_paragraphs;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Component\Utility\Unicode;

/**
 * Renders a Carousel paragraph.
 */
class CarouselParagraph implements ParagraphRendererInterface {
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
    $this->config = $config_factory->get('leadgen_paragraphs.carousel_settings');
  }

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
            '#type' => 'processed_text',
            '#text' => $slide_paragraph->field_text->value,
            '#format' => $slide_paragraph->field_text->format,
          ];
        }

        if (!$slide_paragraph->field_image->isEmpty()) {
          // Get image field.
          $image_field = $slide_paragraph->field_image;
          $image_style = $this->config->get('image_style');
          // Generate image URL.
          if (!empty($image_style)) {
            $item['image'] = [
              '#theme' => 'image_style',
              '#style_name' => $image_style,
            ];
          }
          else {
            $item['image'] = [
              '#theme' => 'image',
            ];
          }

          // Do not output an empty 'title' attribute.
          if (Unicode::strlen($image_field->title) != 0) {
            $item['image']['#title'] = $image_field->title;
          }

          if (($entity = $image_field->entity) && empty($image_field->uri)) {
            $item['image']['#uri'] = $entity->getFileUri();
          }
          else {
            $item['image']['#uri'] = $image_field->uri;
          }

          foreach (array('width', 'height', 'alt') as $key) {
            $item['image']["#$key"] = $image_field->$key;
          }
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
