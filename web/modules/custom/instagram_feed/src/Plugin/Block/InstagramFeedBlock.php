<?php

namespace Drupal\instagram_feed\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\instagram_feed\Service\InstagramService;

/**
 * @Block(
 *   id = "instagram_feed_block",
 *   admin_label = @Translation("Instagram Feed Block")
 * )
 */
class InstagramFeedBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $instagramService;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, InstagramService $instagramService) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->instagramService = $instagramService;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('instagram_feed.service')
    );
  }

  public function build() {
    return [
      '#theme' => 'instagram_feed',
      '#items' => $this->instagramService->getFeed(),
      '#cache' => [
        'max-age' => 3600,
      ],
    ];
  }
}