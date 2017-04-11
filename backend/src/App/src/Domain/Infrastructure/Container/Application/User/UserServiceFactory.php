<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 10/04/17
 * Time: 23:09
 */

namespace App\Domain\Infrastructure\Container\Application\User;


use App\Domain\Application\User\UserService;
use App\Domain\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

class UserServiceFactory
{

    public function __invoke(ContainerInterface $container)
    {
        $em = $container->get(EntityManager::class);

        $repository = new UserRepository($em);

        return new UserService($repository);
    }

}