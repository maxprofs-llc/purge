<?php

/**
 * @file
 * Contains \Drupal\purge\Annotation\PurgePurger.
 */

namespace Drupal\purge\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a PurgePurger annotation object.
 *
 * @Annotation
 */
class PurgePurger extends Plugin {

  /**
   * The plugin ID of the purger plugin.
   *
   * @var string
   */
  public $id;

  /**
   * The human-readable name of the purger plugin.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $label;

  /**
   * The description of the purger plugin.
   *
   * @ingroup plugin_translatable
   *
   * @var \Drupal\Core\Annotation\Translation
   */
  public $description;

  /**
   * A list of invalidation types that are supported by the purger plugin, for
   * instance 'tag', 'path' or 'url'. The plugin will only receive invalidation
   * requests for the given types, others fail with state STATE_UNSUPPORTED. It
   * is possible to dynamically provide this list by overloading the base
   * implementation of \Drupal\purge\Plugin\Purge\Purger\SharedInterface::getTypes().
   *
   * @see \Drupal\purge\Plugin\Purge\Purger\SharedInterface::getTypes()
   *
   * @var string[]
   */
  public $types = [];

  /**
   * Whether end users can create more then one instance of the purger plugin.
   *
   * When you set 'multi_instance = TRUE' in your plugin annotation, it
   * becomes possible for end-users to create multiple instances of your
   * purger. With \Drupal\purge\Plugin\Purge\Purger\PurgerInterface::getId(), you can read
   * the unique identifier of your instance to keep multiple instances apart.
   *
   * @var bool
   */
  public $multi_instance = FALSE;

  /**
   * Full class name of the configuration form of your purger, with leading
   * backslash. Class must extend \Drupal\purge_ui\Form\PurgerConfigFormBase.
   *
   * @var string
   */
  public $configform = '';

}
