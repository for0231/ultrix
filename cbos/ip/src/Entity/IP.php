<?php

namespace Drupal\ip\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the IPS.
 *
 * @ingroup ip
 *
 * @ContentEntityType(
 *   id = "ip",
 *   label = @Translation("IP"),
 *   label_collection = @Translation("IP"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\ip\IPListBuilder",
 *     "views_data" = "Drupal\ip\Entity\IPViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\ip\Form\IPForm",
 *       "add" = "Drupal\ip\Form\IPForm",
 *       "edit" = "Drupal\ip\Form\IPForm",
 *       "delete" = "Drupal\ip\Form\IPDeleteForm",
 *     },
 *     "access" = "Drupal\ip\IPAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\ip\IPHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "ip",
 *   admin_permission = "administer ips",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/ip/{ip}",
 *     "add-form" = "/admin/ip/add",
 *     "edit-form" = "/admin/ip/{ip}/edit",
 *     "delete-form" = "/admin/ip/{ip}/delete",
 *     "collection" = "/admin/ip",
 *   },
 *   field_ui_base_route = "ip.settings"
 * )
 */
class IP extends ContentEntityBase implements IPInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    $this->set('iplong', ip2long($this->label()));
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the IPS.'))
      ->setSettings([
        'max_length' => 15,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['iplong'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('IP Number'))
      ->setDescription(t('The number of ip.'))
      ->setSetting('unsigned', TRUE)
      ->setSetting('size', 'big');

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Ip is published.'))
      ->setDefaultValue(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
