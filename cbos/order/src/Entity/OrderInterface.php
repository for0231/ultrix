<?php

namespace Drupal\order\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Orders.
 *
 * @ingroup order
 */
interface OrderInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Order name.
   *
   * @return string
   *   Name of the Order.
   */
  public function getName();

  /**
   * Sets the Order name.
   *
   * @param string $name
   *   The Order name.
   *
   * @return \Drupal\order\Entity\OrderInterface
   *   The called Order entity.
   */
  public function setName($name);

  /**
   * Gets the Order creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Order.
   */
  public function getCreatedTime();

  /**
   * Sets the Order creation timestamp.
   *
   * @param int $timestamp
   *   The Order creation timestamp.
   *
   * @return \Drupal\order\Entity\OrderInterface
   *   The called Order entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Order published status indicator.
   *
   * Unpublished Order are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Order is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Order.
   *
   * @param bool $published
   *   TRUE to set this Order to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\order\Entity\OrderInterface
   *   The called Order entity.
   */
  public function setPublished($published);

  /**
   * Gets the Order revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Order revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\order\Entity\OrderInterface
   *   The called Order entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Order revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Order revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\order\Entity\OrderInterface
   *   The called Order entity.
   */
  public function setRevisionUserId($uid);

}
