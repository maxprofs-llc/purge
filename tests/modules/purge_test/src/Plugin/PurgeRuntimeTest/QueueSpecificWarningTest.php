<?php

/**
 * @file
 * Contains \Drupal\purge_test\Plugin\PurgeRuntimeTest\QueueSpecificWarningTest.
 */

namespace Drupal\purge_test\Plugin\PurgeRuntimeTest;

use Drupal\purge\RuntimeTest\PluginInterface;
use Drupal\purge\RuntimeTest\PluginBase;

/**
 * Tests if there is a purger plugin that invalidates an external cache.
 *
 * @PurgeRuntimeTest(
 *   id = "queuewarning",
 *   title = @Translation("Queue specific warning"),
 *   description = @Translation("A fake test to test the runtime tests api."),
 *   service_dependencies = {},
 *   dependent_queue_plugins = {"queue_b"},
 *   dependent_purger_plugins = {}
 * )
 */
class QueueSpecificWarningTest extends PluginBase implements PluginInterface {

  /**
   * {@inheritdoc}
   */
  public function run() {
    $this->recommendation = "This is a queue warning for unit testing.";
    return SELF::SEVERITY_WARNING;
  }
}
