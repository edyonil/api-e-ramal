<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 10/04/17
 * Time: 21:54
 */

namespace App\Core\Factory;


use Doctrine\Common\Cache\ArrayCache;
use Interop\Container\ContainerInterface;

class DoctrineCacheFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ArrayCache();
    }
}