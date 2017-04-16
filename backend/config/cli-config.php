<?php

require __DIR__ .'./../vendor/autoload.php';

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

$container = require 'container.php';

$em = $container->get(EntityManager::class);

return ConsoleRunner::createHelperSet($em);