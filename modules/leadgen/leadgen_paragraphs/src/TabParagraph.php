<?php

/**
 * @file
 * Contains \Drupal\leadgen_paragraphs\TabParagraph.
 */

namespace Drupal\leadgen_paragraphs;

/**
 * Renders a banner paragraph.
 */
class TabParagraph implements ParagraphRendererInterface {

  /**
   * {@inheritdoc}
   */
  public function render(array &$variables) {
    $tab_titles = [];
    $tab_text = [];

    $paragraph = $variables['paragraph'];
    if (!$paragraph->field_paragraphs->isEmpty()) {

      $paragraphs = $paragraph->field_paragraphs->referencedEntities();

      foreach ($paragraphs as $paragraph) {

        $para_titles = [];
        $para_text = [];

        if (!$paragraph->field_title->isEmpty()) {
          $para_titles['title'] = $paragraph->field_title->value;
          $para_titles['id'] = 'paras-' . $paragraph->id();
        }
        if (!$paragraph->field_text->isEmpty()) {
          $para_text['text'] = [
            '#type' => 'processed_text',
            '#text' => $paragraph->field_text->value,
            '#format' => $paragraph->field_text->format,
          ];
          $para_text['id'] = 'paras-' . $paragraph->id();
        }

        if (!empty($para_titles)) {
          $tab_titles[] = $para_titles;
        }

        if (!empty($para_text)) {
          $tab_text[] = $para_text;
        }
      }
    }

    $variables['content']['tabs'] = [
      '#theme' => 'leadgen_paragraphs_tab',
      '#tab_titles' => $tab_titles,
      '#tab_text' => $tab_text,
    ];
  }
}
