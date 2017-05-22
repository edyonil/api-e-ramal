<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Aplicacao\Autenticacao;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoJWT;
use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoService;
use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoServiceFactory;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioAutenticacaoRepositorio;
use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class AutenticacaoServiceFactoryTest
 *
 * @package AppTest\ContatoModulo\Aplicacao\Autenticacao
 * @author Alex Gomes <alexrsg@gmail.com>
 *
 * @group ContatoModulo
 */
class AutenticacaoServiceFactoryTest extends TestCase
{
    public function testVerificarCarregamentoDoServicoDeAutenticacao()
    {
        $container = $this->prophesize(ContainerInterface::class);

        $container->get(AutenticacaoJWT::class)->willReturn(
            $this->prophesize(AutenticacaoJWT::class)->reveal()
        );

        $container->get(UsuarioAutenticacaoRepositorio::class)->willReturn(
            $this->prophesize(UsuarioAutenticacaoRepositorio::class)->reveal()
        );

        $factory = new AutenticacaoServiceFactory();
        $servico = $factory($container->reveal());

        $this->assertInstanceOf(AutenticacaoService::class, $servico);
    }
}
