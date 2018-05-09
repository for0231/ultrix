<?php

namespace Drupal\Tests\ip\Functional;

use Drupal\Core\Url;

/**
 * Simple test for ip list.
 *
 * @group ip
 */
class IpListTest extends IpTestBase {

  public function testList() {
    $ip = $this->createIp();

    $user = $this->drupalCreateUser([
      'view published ips',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.ip.collection'));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists($ip->label());
  }

}
