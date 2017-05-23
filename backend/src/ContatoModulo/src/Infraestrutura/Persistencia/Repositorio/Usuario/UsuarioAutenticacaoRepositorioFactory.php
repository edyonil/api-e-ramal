<?php
declare(strict_types=1);

namespace ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Class UsuarioAutenticacaoRepositorioFactory
 *
 * @package ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario
 * @author Alex Gomes <alexrsg@gmail.com>
 */
class UsuarioAutenticacaoRepositorioFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) {
        return new UsuarioAutenticacaoRepositorio($container->get(EntityManager::class));
    }
}
