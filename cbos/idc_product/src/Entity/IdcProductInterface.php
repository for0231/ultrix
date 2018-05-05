<?php

namespace Drupal\idc_product\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Idc Products.
 *
 * @ingroup idc_product
 */
interface IdcProductInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Idc Product name.
   *
   * @return string
   *   Name of the Idc Product.
   */
  public function getName();

  /**
   * Sets the Idc Product name.
   *
   * @param string $name
   *   The Idc Product name.
   *
   * @return \Drupal\idc_product\Entity\IdcProductInterface
   *   The called Idc Product entity.
   */
  public function setName($name);

  /**
   * Gets the Idc Product creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Idc Product.
   */
  public function getCreatedTime();

  /**
   * Sets the Idc Product creation timestamp.
   *
   * @param int $timestamp
   *   The Idc Product creation timestamp.
   *
   * @return \Drupal\idc_product\Entity\IdcProductInterface
   *   The called Idc Product entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Idc Product published status indicator.
   *
   * Unpublished Idc Product are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Idc Product is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Idc Product.
   *
   * @param bool $published
   *   TRUE to set this Idc Product to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\idc_product\Entity\IdcProductInterface
   *   The called Idc Product entity.
   */
  public function setPublished($published);

  /**
   * Gets the Idc Product revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Idc Product revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\idc_product\Entity\IdcProductInterface
   *   The called Idc Product entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Idc Product revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Idc Product revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\idc_product\Entity\IdcProductInterface
   *   The called Idc Product entity.
   */
  public function setRevisionUserId($uid);

}
