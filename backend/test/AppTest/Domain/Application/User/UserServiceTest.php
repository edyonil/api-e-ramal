<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 10/04/17
 * Time: 22:27
 */

namespace AppTest\Domain\Application\User;

use PHPUnit\Framework\TestCase;
use App\Domain\Model\User;
use App\Domain\Infrastructure\Repository\UserRepository;
use App\Domain\Application\User\UserService;

/**
 * Class UserServiceTest
 * @package AppTest\Domain\Application\User
 *
 * @group UserService
 */
class UserServiceTest extends TestCase
{
    public function testUserServiceAll()
    {
        $user = new User();
        $user->setName('Edy Borges');
        $user->setEmail('edyonil@gmail.com');

        $userRepository = $this->prophesize(UserRepository::class);
        $userRepository->all()->willReturn([$user]);

        $userService = new UserService($userRepository->reveal());

        $users = $userService->listAllUsers();

        $this->assertCount(1, $users);
        $this->assertInstanceOf(User::class, $users[0]);

    }
}
