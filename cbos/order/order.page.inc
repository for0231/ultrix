<?php

/**
 * @file
 * Contains order.page.inc.
 *
 * Page callback for Orders.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Order templates.
 *
 * Default template: order.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_order(array &$variables) {
  // Fetch Order Entity Object.
  $order = $variables['elements']['#order'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
