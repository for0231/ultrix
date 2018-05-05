<?php

namespace Drupal\product\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Product type entity.
 *
 * @ConfigEntityType(
 *   id = "product_type",
 *   label = @Translation("Product type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\product\ProductTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\product\Form\ProductTypeForm",
 *       "edit" = "Drupal\product\Form\ProductTypeForm",
 *       "delete" = "Drupal\product\Form\ProductTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\product\ProductTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "product_type",
 *   admin_permission = "administer products",
 *   bundle_of = "product",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/product/type/{product_type}",
 *     "add-form" = "/product/type/add",
 *     "edit-form" = "/product/type/{product_type}/edit",
 *     "delete-form" = "/product/type/{product_type}/delete",
 *     "collection" = "/product/type"
 *   }
 * )
 */
class ProductType extends ConfigEntityBundleBase implements ProductTypeInterface {

  /**
   * The Product type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Product type label.
   *
   * @var string
   */
  protected $label;

}
