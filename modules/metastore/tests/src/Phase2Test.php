<?php

namespace Drupal\Tests\metastore;

use Drupal\Component\Uuid\Php;
use Drupal\Component\Uuid\Uuid;
use Drupal\metastore\Phase2;
use MockChain\Chain;
use MockChain\Options;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Phase2Test extends TestCase {

  public function testRegister() {
    $container = $this->getCommonMockChain();
    $p2 = Phase2::create($container->getMock());

    $uuidReturned = $p2->register("s3://bucket/filename.ext");
    $this->assertTrue(Uuid::isValid($uuidReturned));

  }

  private function getCommonMockChain() {
    $options = (new Options())
      ->add('uuid', new Php())
      ->index(0);

    $container = (new Chain($this))
      ->add(ContainerInterface::class, 'get', $options);

    return $container;
  }

}
