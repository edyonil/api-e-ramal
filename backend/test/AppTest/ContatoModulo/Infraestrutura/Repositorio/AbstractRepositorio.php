<?php declare(strict_types=1);

namespace AppTest\ContatoModulo\Infraestrutura\Repositorio;

use \PHPUnit\Framework\TestCase;

/**
 * @group VerificaLogin
 */
abstract class AbstractRepositorio extends TestCase
{
    protected static $container;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $container = require __DIR__ .'/../../../../../config/container.php';

        self::$container = $container;
    }

    public static function obterContainer($classe)
    {
        return self::$container->get($classe);
    }
}
