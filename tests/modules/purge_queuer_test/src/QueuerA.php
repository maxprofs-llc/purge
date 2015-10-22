<?php

/**
 * @file
 * Contains \Drupal\purge_queuer_test\QueuerA.
 */

namespace Drupal\purge_queuer_test;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\purge\Queuer\QueuerInterface;
use Drupal\purge\Plugin\Purge\Queue\QueueServiceInterface;
use Drupal\purge\Plugin\Purge\Invalidation\InvalidationsServiceInterface;

/**
 * Testing queuer A.
 */
class QueuerA implements QueuerInterface {
  use StringTranslationTrait;

  /**
   * The container id of this queuer.
   *
   * @var string
   */
  protected $id;

  /**
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The config prefix and setting field holding status for this queuer.
   *
   * @var array
   */
  protected $config = ['purge_queuer_test.status', 'a'];

  /**
   * Whether this queuer is enabled.
   *
   * @var bool
   */
  protected $status;

  /**
   * The purge queue service.
   *
   * @var \Drupal\purge\Plugin\Purge\Queue\QueueServiceInterface
   */
  protected $purgeQueue;

  /**
   * @var \Drupal\purge\Plugin\Purge\Invalidation\InvalidationsServiceInterface
   */
  protected $purgeInvalidationFactory;

  /**
   * Constructs a new QueuerA.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   * @param \Drupal\purge\Plugin\Purge\Queue\QueueServiceInterface $purge_queue
   *   The purge queue service.
   * @param \Drupal\purge\Plugin\Purge\Invalidation\InvalidationsServiceInterface $purge_invalidation_factory
   *   The invalidation objects factory service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, QueueServiceInterface $purge_queue, InvalidationsServiceInterface $purge_invalidation_factory) {
    $this->configFactory = $config_factory;
    $this->purgeInvalidationFactory = $purge_invalidation_factory;
    $this->purgeQueue = $purge_queue;

    list($prefix, $key) = $this->config;
    $this->status = $this->configFactory->get($prefix)->get($key);
  }

  /**
   * {@inheritdoc}
   */
  public function disable() {
    list($prefix, $key) = $this->config;
    $this->configFactory->getEditable($prefix)->set($key, FALSE)->save();
    $this->status = FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function enable() {
    list($prefix, $key) = $this->config;
    $this->configFactory->getEditable($prefix)->set($key, TRUE)->save();
    $this->status = TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function isEnabled() {
    return $this->status;
  }

  /**
   * {@inheritdoc}
   */
  public function getId() {
    return $this->id;
  }

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    return $this->t("Queuer A");
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->t("A test queuer that adds a path when you enable it.");
  }

  /**
   * {@inheritdoc}
   */
  public function setId($id) {
    $this->id = $id;
  }

}
