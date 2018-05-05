<?php

namespace Drupal\idc_product\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Idc Product type entity.
 *
 * @ConfigEntityType(
 *   id = "idc_product_type",
 *   label = @Translation("Idc Product type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\idc_product\IdcProductTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\idc_product\Form\IdcProductTypeForm",
 *       "edit" = "Drupal\idc_product\Form\IdcProductTypeForm",
 *       "delete" = "Drupal\idc_product\Form\IdcProductTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\idc_product\IdcProductTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "idc_product_type",
 *   admin_permission = "administer idc products",
 *   bundle_of = "idc_product",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/product/type/{idc_product_type}",
 *     "add-form" = "/product/type/add",
 *     "edit-form" = "/product/type/{idc_product_type}/edit",
 *     "delete-form" = "/product/type/{idc_product_type}/delete",
 *     "collection" = "/product/type"
 *   }
 * )
 */
class IdcProductType extends ConfigEntityBundleBase implements IdcProductTypeInterface {

  /**
   * The Idc Product type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Idc Product type label.
   *
   * @var string
   */
  protected $label;

}
