<?php

namespace Drupal\idc_product;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\idc_product\Entity\IdcProductInterface;

/**
 * Defines the storage handler class for Idc Products.
 *
 * This extends the base storage class, adding required special handling for
 * Idc Products.
 *
 * @ingroup idc_product
 */
class IdcProductStorage extends SqlContentEntityStorage implements IdcProductStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(IdcProductInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {idc_product_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {idc_product_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(IdcProductInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {idc_product_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('idc_product_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
