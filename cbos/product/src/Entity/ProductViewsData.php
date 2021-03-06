<?php

namespace Drupal\product\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Products.
 */
class ProductViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.

    return $data;
  }

}
