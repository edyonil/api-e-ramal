<?php
declare(strict_types=1);

namespace ContatoModulo\Infraestrutura\Container\Aplicacao\Usuario;

use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioRepositorio;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

class UsuarioServicoFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $em = $container->get(EntityManager::class);

        $repository = new UsuarioRepositorio($em);

        return new UsuarioServico($repository);
    }
}
