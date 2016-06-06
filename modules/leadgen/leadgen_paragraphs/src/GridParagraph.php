<?php

/**
 * @file
 * Contains \Drupal\leadgen_paragraphs\GridParagraph.
 */

namespace Drupal\leadgen_paragraphs;

/**
 * Renders a grid paragraph.
 */
class GridParagraph implements ParagraphRendererInterface {

  /**
   * {@inheritdoc}
   */
  public function render(array &$variables) {
    $items = [];
    $paragraph = $variables['paragraph'];
    // Get column value.
    $column = $paragraph->field_columns->value;
    // Check if paragraphs field is not empty.
    if (!$paragraph->field_paragraphs->isEmpty()) {
      // Get referenced paragraphs
      $paragraphs = $paragraph->field_paragraphs->referencedEntities();
      foreach($paragraphs as $paragraph) {
        $para_text = [];
        if (!$paragraph->field_text->isEmpty()) {
          $para_text['text'] = [
            '#type' => 'processed_text',
            '#text' => $paragraph->field_text->value,
            '#format' => $paragraph->field_text->format,
          ];
        }
        if (!empty($para_text)) {
          $items[] = $para_text;
        }
      }
    }

    if (!empty($items)) {
      $variables['content']['grid'] = [
        '#theme' => 'leadgen_paragraphs_grid',
        '#items' => $items,
        '#col_width' => $column,
      ];
      hide($variables['content']['field_paragraphs']);
    }
  }
}
