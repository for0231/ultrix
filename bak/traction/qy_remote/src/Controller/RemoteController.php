<?php
/**
 * @file
 * Contains \Drupal\qy_remote\Controller\RemoteController.
 */

namespace Drupal\qy_remote\Controller;

use Drupal\Core\Controller\ControllerBase;

class RemoteController extends ControllerBase {
  /**
   * �����ӿ�ǣ���б�
   */
  public function remoteTraction() {
    $build['contnet'] =  array(
      '#type' => 'container',
      '#attributes' => array(
        'class' => array('ajax-content'),
        'ajax-refresh' => 'true',
        'ajax-path' => \Drupal::url('admin.qy.ajax.list', array('module_provider' => 'remote', 'list_type' => 'remote'))
      ),
      '#attached' => array(
        'library' => array('qy/drupal.ajax-content')
      )
    );
    return $build;
  }
}