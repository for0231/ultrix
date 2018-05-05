<?php

namespace Drupal\order\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class OrderTypeForm.
 */
class OrderTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $order_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $order_type->label(),
      '#description' => $this->t("Label for the Order type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $order_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\order\Entity\OrderType::load',
      ],
      '#disabled' => !$order_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $order_type = $this->entity;
    $status = $order_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Order type.', [
          '%label' => $order_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Order type.', [
          '%label' => $order_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($order_type->toUrl('collection'));
  }

}
