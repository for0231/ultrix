<?php

namespace Drupal\order\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Order type entity.
 *
 * @ConfigEntityType(
 *   id = "order_type",
 *   label = @Translation("Order type"),
 *   label_collection = @Translation("Order type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\order\OrderTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\order\Form\OrderTypeForm",
 *       "edit" = "Drupal\order\Form\OrderTypeForm",
 *       "delete" = "Drupal\order\Form\OrderTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\order\OrderTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "type",
 *   admin_permission = "administer orders",
 *   bundle_of = "order",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/order/type/{order_type}",
 *     "add-form" = "/order/type/add",
 *     "edit-form" = "/order/type/{order_type}/edit",
 *     "delete-form" = "/order/type/{order_type}/delete",
 *     "collection" = "/order/type"
 *   }
 * )
 */
class OrderType extends ConfigEntityBundleBase implements OrderTypeInterface {

  /**
   * The Order type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Order type label.
   *
   * @var string
   */
  protected $label;

}
