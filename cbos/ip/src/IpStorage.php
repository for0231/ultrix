<?php

namespace Drupal\ip;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\ip\Entity\IpInterface;

/**
 * Defines the storage handler class for IPs.
 *
 * This extends the base storage class, adding required special handling for
 * IPs.
 *
 * @ingroup ip
 */
class IpStorage extends SqlContentEntityStorage implements IpStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(IpInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {ip_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {ip_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(IpInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {ip_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('ip_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
