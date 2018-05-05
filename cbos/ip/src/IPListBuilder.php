<?php

namespace Drupal\ip;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Ip entities.
 *
 * @ingroup ip
 */
class IPListBuilder extends EntityListBuilder {


  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Ip ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\ip\Entity\IP */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.ip.edit_form',
      ['ip' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
