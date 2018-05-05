<?php

namespace Drupal\order;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\order\Entity\OrderInterface;

/**
 * Defines the storage handler class for Orders.
 *
 * This extends the base storage class, adding required special handling for
 * Orders.
 *
 * @ingroup order
 */
interface OrderStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Order revision IDs for a specific Order.
   *
   * @param \Drupal\order\Entity\OrderInterface $entity
   *   The Order entity.
   *
   * @return int[]
   *   Order revision IDs (in ascending order).
   */
  public function revisionIds(OrderInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Order author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Order revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\order\Entity\OrderInterface $entity
   *   The Order entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(OrderInterface $entity);

  /**
   * Unsets the language for all Order with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
