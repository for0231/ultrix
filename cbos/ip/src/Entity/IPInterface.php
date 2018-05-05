<?php

namespace Drupal\ip\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;

/**
 * Provides an interface for defining IPS.
 *
 * @ingroup ip
 */
interface IPInterface extends ContentEntityInterface, EntityChangedInterface {

  /**
   * Gets the Ip name.
   *
   * @return string
   *   Name of the Ip.
   */
  public function getName();

  /**
   * Sets the Ip name.
   *
   * @param string $name
   *   The Ip name.
   *
   * @return \Drupal\ip\Entity\IPInterface
   *   The called IPS.
   */
  public function setName($name);

  /**
   * Gets the Ip creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Ip.
   */
  public function getCreatedTime();

  /**
   * Sets the Ip creation timestamp.
   *
   * @param int $timestamp
   *   The Ip creation timestamp.
   *
   * @return \Drupal\ip\Entity\IPInterface
   *   The called IPS.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Ip published status indicator.
   *
   * Unpublished Ip are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Ip is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Ip.
   *
   * @param bool $published
   *   TRUE to set this Ip to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\ip\Entity\IPInterface
   *   The called IPS.
   */
  public function setPublished($published);

}
