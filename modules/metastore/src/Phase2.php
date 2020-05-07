<?php

namespace Drupal\metastore;

use Drupal\Component\Uuid\UuidInterface;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Phase2 implements ContainerInjectionInterface {

  /**
   * @var \Drupal\Component\Uuid\UuidInterface
   */
  private $uuidService;

  private $urlStorage = [];

  public function __construct(UuidInterface $uuidService) {
    $this->uuidService = $uuidService;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('uuid')
    );
  }

  public function register(string $url) : string {
    if (in_array($url, $this->urlStorage)) {
      throw new \Exception('Url already registered.');
    }

    $uuid = $this->uuidService->generate();
    $this->urlStorage[$uuid] = $url;

    return $uuid;
  }

  public function retrieveLocalUrl(string $uuid) : string {
    if (!isset($this->urlStorage[$uuid])) {
      throw new \Exception('Unknown url.');
    }
    return $this->urlStorage[$uuid];
  }

}
