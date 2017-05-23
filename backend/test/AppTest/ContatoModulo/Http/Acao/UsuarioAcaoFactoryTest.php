<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use ContatoModulo\Http\Acao\ListarUsuarioAcao;
use ContatoModulo\Http\Acao\UsuarioAcaoFactory;
use PHPUnit\Framework\TestCase;
use Interop\Container\ContainerInterface;

/**
 * Class UsuarioAcaoFactoryTest
 *
 * @package AppTest\ContatoModulo\Http\Acao
 * @author Alex Gomes <alexrsg@gmail.com>
 */
class UsuarioAcaoFactoryTest extends TestCase
{
    public function testVerificarCarregamentoDaAcaoDeListarUsuarios()
    {
        $container = $this->prophesize(ContainerInterface::class);
        $container->get(UsuarioServico::class)->willReturn(
            $this->prophesize(UsuarioServico::class)->reveal()
        )->shouldBeCalled();

        $factory = new UsuarioAcaoFactory();
        $acao = $factory($container->reveal(), ListarUsuarioAcao::class);

        $this->assertInstanceOf(ListarUsuarioAcao::class, $acao);
    }
}
