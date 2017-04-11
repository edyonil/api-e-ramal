<?php
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require 'vendor/autoload.php';

$container = require 'container.php';

$em = $container->get(EntityManager::class);

return ConsoleRunner::createHelperSet($em);