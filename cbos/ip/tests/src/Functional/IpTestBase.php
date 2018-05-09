<?php

namespace Drupal\Tests\ip\Functional;

use Drupal\ip\Entity\Ip;
use Drupal\ip\Entity\IpType;
use Drupal\Tests\BrowserTestBase;

abstract class IpTestBase extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['ip'];

  /**
   * @param array $settings
   *
   * @return \Drupal\Core\Entity\EntityInterface|static
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function createIp(array $settings = []) {
    $settings += [
      'name' => $this->randomMachineName(),
    ];
    $entity = Ip::create($settings);
    $entity->save();

    return $entity;
  }


  /**
   * @param array $settings
   *
   * @return \Drupal\Core\Entity\EntityInterface|\Drupal\ip\Entity\IpType
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function createIpType(array $settings = []) {
    $settings += [
      'id' => strtolower($this->randomMachineName()),
      'label' => $this->randomMachineName(),
    ];
    $entity = IpType::create($settings);
    $entity->save();

    return $entity;
  }

}
