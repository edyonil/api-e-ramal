<?php

namespace AppTest\ContatoModulo\Infraestrutura\Repositorio;

use PHPUnit\Framework\TestCase;

abstract class AbstractRepositorioTest extends TestCase
{
    protected $container;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $container = require __DIR__ .'/../../../../config/container.php';

        $this->container = $container;
    }
}
