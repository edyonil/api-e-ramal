<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 10/04/17
 * Time: 21:06
 */

namespace AppTest\Core\Factory;

use App\Core\Factory\DoctrineCacheFactory;
use App\Core\Factory\DoctrineFactory;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Cache\Cache;

/**
 * Class DoctrineFactoryTest
 *
 * @package AppTest\Core\Factory
 *
 * @group DoctrineFactory
 */
class DoctrineFactoryTest extends TestCase
{
    protected $container;

    public function setUp()
    {

        $this->container = $this->prophesize(ContainerInterface::class);
    }

    public function testCreateFactoryDoctrine()
    {
        $doctrineContainer = new DoctrineFactory();

        $this->container->has('config')->willReturn(true);

        $this->container->get('config')->willReturn($this->getConfigFile());

        $this->container->get(Cache::class)
             ->willReturn((new DoctrineCacheFactory())($this->container->reveal()));

        $container = $doctrineContainer($this->container->reveal());

        $this->assertInstanceOf(EntityManager::class, $container);
    }

    private function getConfigFile()
    {
        return require __DIR__ . '/doctrine.php';
    }
}
