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

  public function __construct(UuidInterface $uuidService) {
    $this->uuidService = $uuidService;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('uuid')
    );
  }

  public function register(string $url) : string {
    return $this->uuidService->generate();
  }

}
