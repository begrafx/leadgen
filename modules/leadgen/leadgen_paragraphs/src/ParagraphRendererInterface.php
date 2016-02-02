<?php

/**
 * @file
 * Contains \Drupal\leadgen_paragraphs\ParagraphRendererInterface.
 */

namespace Drupal\leadgen_paragraphs;

/**
 * Interface BannerParagraphInterface.
 *
 * @package Drupal\leadgen_paragraphs
 */
interface ParagraphRendererInterface {

  public function render(array &$variables);
}
