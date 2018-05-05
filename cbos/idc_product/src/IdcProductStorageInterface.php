<?php

namespace Drupal\idc_product;

use Drupal\Core\Entity\ContentEntityStorageInterface;
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
interface IdcProductStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Idc Product revision IDs for a specific Idc Product.
   *
   * @param \Drupal\idc_product\Entity\IdcProductInterface $entity
   *   The Idc Product entity.
   *
   * @return int[]
   *   Idc Product revision IDs (in ascending order).
   */
  public function revisionIds(IdcProductInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Idc Product author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Idc Product revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\idc_product\Entity\IdcProductInterface $entity
   *   The Idc Product entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(IdcProductInterface $entity);

  /**
   * Unsets the language for all Idc Product with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
