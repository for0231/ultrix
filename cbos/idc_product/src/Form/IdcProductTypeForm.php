<?php

namespace Drupal\idc_product\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class IdcProductTypeForm.
 */
class IdcProductTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $idc_product_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $idc_product_type->label(),
      '#description' => $this->t("Label for the Idc Product type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $idc_product_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\idc_product\Entity\IdcProductType::load',
      ],
      '#disabled' => !$idc_product_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $idc_product_type = $this->entity;
    $status = $idc_product_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Idc Product type.', [
          '%label' => $idc_product_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Idc Product type.', [
          '%label' => $idc_product_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($idc_product_type->toUrl('collection'));
  }

}
