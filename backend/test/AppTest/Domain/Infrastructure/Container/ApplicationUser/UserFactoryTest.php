<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 10/04/17
 * Time: 23:10
 */

namespace AppTest\Domain\Infrastructure\Container\ApplicationUser;

use App\Domain\Application\User\UserService;
use App\Domain\Infrastructure\Container\Application\User\UserServiceFactory;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class UserFactoryTest
 * @package AppTest\Domain\Infrastructure\Container\ApplicationUser
 *
 * @group UserFactory
 */
class UserFactoryTest extends TestCase
{
    public function testUserFactory()
    {
        $containerInterface = $this->prophesize(ContainerInterface::class);

        $containerInterface
            ->get(EntityManager::class)
            ->willReturn($this->prophesize(EntityManager::class)->reveal());

        $userServiceFactory = (new UserServiceFactory())($containerInterface->reveal());

        $this->assertInstanceOf(UserService::class, $userServiceFactory);
    }
}
