<?php

namespace Drupal\purge_ui\Tests;

use Drupal\Core\Url;
use Drupal\purge\Tests\WebTestBase;

/**
 * Tests the purger details form.
 *
 * The following classes are covered:
 *   - \Drupal\purge_ui\Form\PluginDetailsForm.
 *   - \Drupal\purge_ui\Controller\PurgerFormController::detailForm().
 *   - \Drupal\purge_ui\Controller\PurgerFormController::detailFormTitle().
 *
 * @group purge_ui
 */
class PurgerDetailsFormTest extends WebTestBase {

  /**
   * The Drupal user entity.
   *
   * @var \Drupal\user\Entity\User
   */
  protected $adminUser;

  /**
   * The route that renders the form.
   *
   * @var string
   */
  protected $route = 'purge_ui.purger_detail_form';

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = ['purge_purger_test', 'purge_ui'];

  /**
   * Setup the test.
   */
  public function setUp() {
    parent::setUp();
    $this->adminUser = $this->drupalCreateUser(['administer site configuration']);
  }

  /**
   * Tests permissions, the form controller and general form returning.
   */
  public function testAccess() {
    $args = ['id' => 'id0'];
    $this->initializePurgersService(['a']);
    $this->drupalGet(Url::fromRoute($this->route, $args));
    $this->assertResponse(403);
    $this->drupalLogin($this->adminUser);
    $this->drupalGet(Url::fromRoute($this->route, $args));
    $this->assertResponse(200);
    $args = ['id' => 'doesnotexist'];
    $this->drupalGet(Url::fromRoute($this->route, $args));
    $this->assertResponse(404);
  }

  /**
   * Tests that the close button works and that content exists.
   *
   * @see \Drupal\purge_ui\Form\PurgerDetailForm::buildForm
   * @see \Drupal\purge_ui\Form\CloseDialogTrait::closeDialog
   */
  public function testDetailForm() {
    $args = ['id' => 'id0'];
    $this->initializePurgersService(['a']);
    $this->drupalLogin($this->adminUser);
    $this->drupalGet(Url::fromRoute($this->route, $args));
    $this->assertRaw('Purger A');
    $this->assertRaw('Test purger A.');
    $this->assertRaw('Close');
    $json = $this->drupalPostAjaxForm(Url::fromRoute($this->route, $args)->toString(), [], ['op' => 'Close']);
    $this->assertEqual('closeDialog', $json[1]['command']);
    $this->assertEqual(2, count($json));
  }

}
