<?php

namespace Drupal\ip;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\ip\Entity\IpInterface;

/**
 * Defines the storage handler class for IP entities.
 *
 * This extends the base storage class, adding required special handling for
 * IP entities.
 *
 * @ingroup ip
 */
interface IpStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of IP revision IDs for a specific IP.
   *
   * @param \Drupal\ip\Entity\IpInterface $entity
   *   The IP entity.
   *
   * @return int[]
   *   IP revision IDs (in ascending order).
   */
  public function revisionIds(IpInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as IP author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   IP revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\ip\Entity\IpInterface $entity
   *   The IP entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(IpInterface $entity);

  /**
   * Unsets the language for all IP with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
