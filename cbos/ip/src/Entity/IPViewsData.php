<?php

namespace Drupal\ip\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for IPs.
 */
class IpViewsData extends EntityViewsData {

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
