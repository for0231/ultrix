<?php

namespace Drupal\ip\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the IP type entity.
 *
 * @ConfigEntityType(
 *   id = "ip_type",
 *   label = @Translation("IP type"),
 *   label_collection = @Translation("IP types"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ip\IpTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\ip\Form\IpTypeForm",
 *       "edit" = "Drupal\ip\Form\IpTypeForm",
 *       "delete" = "Drupal\ip\Form\IpTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\ip\IpTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "type",
 *   admin_permission = "administer ips",
 *   bundle_of = "ip",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/ip/type/{ip_type}",
 *     "add-form" = "/ip/type/add",
 *     "edit-form" = "/ip/type/{ip_type}/edit",
 *     "delete-form" = "/ip/type/{ip_type}/delete",
 *     "collection" = "/ip/type"
 *   }
 * )
 */
class IpType extends ConfigEntityBundleBase implements IpTypeInterface {

  /**
   * The IP type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The IP type label.
   *
   * @var string
   */
  protected $label;

}
