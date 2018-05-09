<?php

namespace Drupal\Tests\ip\Functional;

use Drupal\Core\Url;

/**
 * Simple test for ip delete.
 *
 * @group ip
 */
class IpDeleteTest extends IpTestBase {

  /**
   * Tests quote_data delete.
   */
  public function testDelete() {
    $ip = $this->createIp();

    $user = $this->drupalCreateUser([
      'view published ips',
      'edit ips',
      'delete ips',
    ]);
    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.ip.edit_form', [
      'ip' => $ip->id(),
    ]));
    $assert_session->statusCodeEquals(200);
    $assert_session->linkExists(t('Delete'));

    $this->clickLink(t('Delete'));
    $assert_session->statusCodeEquals(200);

    $this->drupalPostForm(NULL, [], t('Delete'));
    $assert_session->responseContains(t('The @entity-type %label has been deleted.', [
      '@entity-type' => t('ip'),
      '%label' => $ip->label(),
    ]));
  
  }

}
