<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Infraestrutura\Container\Aplicacao\Contato;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoJWT;
use ContatoModulo\Aplicacao\Contato\ContatoService;
use ContatoModulo\Infraestrutura\Container\Aplicacao\Contato\ContatoServicoFactory;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioAutenticacaoRepositorio;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class ContatoServicoFactoryTest
 *
 * @package AppTest\ContatoModulo\Infraestrutura\Container\Aplicacao\Contato
 * @group ContatoModulo
 */
class ContatoServicoFactoryTest extends TestCase
{
    public function testVerificarCarregamentoDaClasse()
    {
        $container = $this->prophesize(ContainerInterface::class);

        $container->get(EntityManager::class)->willReturn(
            $this->prophesize(EntityManager::class)->reveal())
            ->shouldBeCalled();

        $container->get(AutenticacaoJWT::class)->willReturn(
            $this->prophesize(AutenticacaoJWT::class)->reveal()
        )->shouldBeCalled();

        $container->get(UsuarioAutenticacaoRepositorio::class)->willReturn(
            $this->prophesize(UsuarioAutenticacaoRepositorio::class)->reveal()
        )->shouldBeCalled();

        $factory = new ContatoServicoFactory();

        $servico = $factory($container->reveal());

        $this->assertInstanceOf(ContatoService::class, $servico);
    }
}
