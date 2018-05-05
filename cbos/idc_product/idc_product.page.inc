<?php

/**
 * @file
 * Contains idc_product.page.inc.
 *
 * Page callback for Idc Products.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Idc Product templates.
 *
 * Default template: idc_product.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_idc_product(array &$variables) {
  // Fetch IdcProduct Entity Object.
  $idc_product = $variables['elements']['#idc_product'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
