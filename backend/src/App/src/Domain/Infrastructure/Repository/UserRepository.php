<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 10/04/17
 * Time: 22:57
 */

namespace App\Domain\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use App\Domain\Model\User;

class UserRepository
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function all()
    {
        $userRepository = $this->entityManager
                               ->getRepository(User::class);

        return $userRepository->findAll();
    }
}