<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 10/04/17
 * Time: 23:02
 */

namespace App\Domain\Application\User;


use App\Domain\Infrastructure\Repository\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function listAllUsers() : array
    {
        return $this->userRepository->all();
    }
}