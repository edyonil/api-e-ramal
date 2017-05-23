<?php
declare(strict_types=1);

namespace ContatoModulo\Aplicacao\Autenticacao;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class AutenticacaoJWTFactory
 *
 * @package ContatoModulo\Aplicacao\Autenticacao
 * @author Alex Gomes <alexrsg@gmail.com>
 */
class AutenticacaoJWTFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        return new AutenticacaoJWT();
    }
}
