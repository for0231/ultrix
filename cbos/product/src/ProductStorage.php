<?php

namespace Drupal\product;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\product\Entity\ProductInterface;

/**
 * Defines the storage handler class for Products.
 *
 * This extends the base storage class, adding required special handling for
 * Products.
 *
 * @ingroup product
 */
class ProductStorage extends SqlContentEntityStorage implements ProductStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(ProductInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {product_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {product_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(ProductInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {product_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('product_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
