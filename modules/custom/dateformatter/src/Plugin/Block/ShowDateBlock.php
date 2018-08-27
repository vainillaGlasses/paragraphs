<?php

namespace Drupal\dateformatter\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Datetime\DateFormatterInterface;

/**
 * Provides a 'ShowDateBlock' block.
 *
 * @Block(
 *  id = "show_date_block",
 *  admin_label = @Translation("Show date block"),
 * )
 */
class ShowDateBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Component\Datetime\TimeInterface definition.
   *
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  protected $datetimeTime;
  /**
   * Drupal\Core\Datetime\DateFormatterInterface definition.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;
  /**
   * Constructs a new ShowDateBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    TimeInterface $datetime_time, 
	DateFormatterInterface $date_formatter
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->datetimeTime = $datetime_time;
    $this->dateFormatter = $date_formatter;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('datetime.time'),
      $container->get('date.formatter')
    );
  }
  /**
   * {@inheritdoc}
   */
  public function build() {
    $time = $this->datetimeTime->getRequestTime();
    $formatted_time = $this->dateFormatter->format($time, 'custom', 'd-m-y h:i:s', 'America/Costa_Rica');
    $build = [];
    $build['show_date_block']['#markup'] = $formatted_time;

    return $build;
  }

}
