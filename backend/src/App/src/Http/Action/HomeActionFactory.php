<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 10/04/17
 * Time: 23:36
 */

namespace App\Http\Action;


use App\Domain\Application\User\UserService;
use Interop\Container\ContainerInterface;

class HomeActionFactory
{
    public function __invoke(ContainerInterface $container, $name)
    {
        //var_dump($name);exit;
        $userService   = $container->get(UserService::class);

        return new $name($userService);
    }
}