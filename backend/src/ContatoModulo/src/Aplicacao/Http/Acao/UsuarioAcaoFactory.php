<?php
declare(strict_types=1);

namespace ContatoModulo\Aplicacao\Http\Acao;

use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class UsuarioAcaoFactory
 *
 * @package ContatoModulo\Aplicacao\Acao
 */
class UsuarioAcaoFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return UsuarioServico
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new $requestedName($container->get(UsuarioServico::class));
    }
}
