<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 27/04/17
 * Time: 16:43
 */

namespace AppTest\ContatoModulo\Infraestrutura\Repositorio\Contato;

use AppTest\ContatoModulo\Infraestrutura\Repositorio\AbstractRepositorioTest;
use ContatoModulo\Infraestrutura\Persistencia\Contato\Repositorio\ContatoRepositorio;

use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

/**
 * Class ContatoRepositorioTest
 *
 * @package ContatoModulo\Infraestrutura\Repositorio\Contato
 *
 * @group ModuloContato/Repositorio
 */
class ContatoRepositorioTest extends AbstractRepositorioTest
{

    public function testAvaliaSeFuncionaContainer()
    {
        $this->assertInstanceOf(ContainerInterface::class, $this->container);
    }

    public function testAdicionandoContato()
    {

    }

    private function repositorio()
    {
        $entityManager = $this->container->get(EntityManager::class);
        return new ContatoRepositorio($entityManager);
    }
}
