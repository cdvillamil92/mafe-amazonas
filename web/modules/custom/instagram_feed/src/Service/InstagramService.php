<?php

namespace Drupal\instagram_feed\Service;

use GuzzleHttp\ClientInterface;
use Drupal\Core\Cache\CacheBackendInterface;

class InstagramService {

  protected $httpClient;
  protected $cache;

  protected $accessToken = 'TU_ACCESS_TOKEN';

  public function __construct(ClientInterface $http_client, CacheBackendInterface $cache) {
    $this->httpClient = $http_client;
    $this->cache = $cache;
  }

  public function getFeed() {
    // 🔹 Intentar cache primero
    if ($cache = $this->cache->get('instagram_feed')) {
      return $cache->data;
    }

    try {
      $response = $this->httpClient->request('GET', 'https://graph.instagram.com/me/media', [
        'query' => [
          'fields' => 'id,media_url,permalink,caption',
          'access_token' => $this->accessToken,
          'limit' => 9,
        ],
      ]);

      $data = json_decode($response->getBody(), TRUE);

      $items = $data['data'] ?? [];

      // 🔹 Guardar cache (1 hora)
      $this->cache->set('instagram_feed', $items, time() + 3600);

      return $items;

    } catch (\Exception $e) {
      return [];
    }
  }
}