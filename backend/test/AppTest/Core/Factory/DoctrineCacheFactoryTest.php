<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 10/04/17
 * Time: 21:47
 */

namespace AppTest\Core\Factory;

use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Cache\ArrayCache;
use App\Core\Factory\DoctrineCacheFactory;

/**
 * Class DoctrineFactoryCacheTest
 * @package AppTest\Core\Factory
 *
 * @group DoctrineFactory
 */
class DoctrineCacheFactoryTest extends TestCase
{

    public function testDoctrineFactoryCache()
    {
        $container = $this->prophesize(ContainerInterface::class)
            ->reveal();

        $this->assertInstanceOf(
            ArrayCache::class,
            (new DoctrineCacheFactory())($container)
        );
    }
}
