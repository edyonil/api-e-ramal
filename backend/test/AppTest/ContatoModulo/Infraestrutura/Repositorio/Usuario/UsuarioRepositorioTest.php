<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Infraestrutura\Repositorio\Usuario;

use AppTest\ContatoModulo\Infraestrutura\Repositorio\AbstractRepositorio;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioRepositorio;

/**
 * Class UsuarioRepositorioTest
 *
 * @group ContatoModulo/Repositorio
 */
class UsuarioRepositorioTest extends AbstractRepositorio
{
    public function testAvaliaSeFuncionaContainer()
    {
        $this->assertInstanceOf(ContainerInterface::class, $this->container);
    }

    public function testVerificaSeEntityManagerEstaFuncionando()
    {
        $repositorio = $this->repositorio();

        $this->assertInstanceOf(UsuarioRepositorio::class, $repositorio);
    }

    private function repositorio()
    {
        $entityManager = $this->container->get(EntityManager::class);

        return new UsuarioRepositorio($entityManager);
    }
}
