<?php

namespace Drupal\idc_product;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Idc Product entity.
 *
 * @see \Drupal\idc_product\Entity\IdcProduct.
 */
class IdcProductAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\idc_product\Entity\IdcProductInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished idc products');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published idc products');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit idc products');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete idc products');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add idc products');
  }

}
