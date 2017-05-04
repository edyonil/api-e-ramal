<?php
declare(strict_types=1);

use AppTest\ContatoModulo\Infraestrutura\Repositorio\AbstractRepositorioTest;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use ContatoModulo\Infraestrutura\Persistencia\Usuario\Repositorio\UsuarioRepositorio;

/**
 * Class UsuarioRepositorioTest
 *
 * @package AppTest\UsuarioModulo\src\Infraestrutura\Persistencia\Repositorio\Usaurio
 * @group ContatoModulo/Repositorio
 */
class UsuarioRepositorioTest extends AbstractRepositorioTest
{
    public function testAvaliaSeFuncionaContainer()
    {
        $this->assertInstanceOf(ContainerInterface::class, $this->container);
    }

    private function repositorio()
    {
        $entityManager = $this->container->get(EntityManager::class);

        return new UsuarioRepositorio($entityManager);
    }
}
