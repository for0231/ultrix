<?php

namespace Drupal\Tests\ip\Functional;

use Drupal\Core\Url;

/**
 * Simple test for ip add form.
 *
 * @group ip
 */
class IpAddTest extends IpTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['block'];

  /**
   * Tests add form.
   */
  public function testAddForm() {
    $this->drupalPlaceBlock('local_actions_block');

    $user = $this->drupalCreateUser([
      'view ips',
    ]);

    $this->drupalLogin($user);

    $assert_session = $this->assertSession();

    $this->drupalGet(Url::fromRoute('entity.ip.add_form', [
      'type' => 'default',
    ]));
    $assert_session->statusCodeEquals(200);

    $edit = [
      'name[0][value]' => $this->randomMachineName(),
    ];
    $this->drupalPostForm(NULL, $edit, t('Save'));
    $assert_session->responseContains(t('Created the %label IP.', [
      '%label' => $edit['name[0][value]'],
    ]));
  }

}
