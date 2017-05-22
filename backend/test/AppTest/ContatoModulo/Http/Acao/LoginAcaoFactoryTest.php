<?php
declare(strict_types=1);

namespace Apptest\ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoService;
use ContatoModulo\Http\Acao\LoginAcao;
use ContatoModulo\Http\Acao\LoginAcaoFactory;
use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class LoginAcaoFactoryTest
 *
 * @package Apptest\ContatoModulo\Http\Acao
 * @author Alex Gomes <alexrsg@gmail.com>
 *
 * @group ContatoModulo
 */
class LoginAcaoFactoryTest extends TestCase
{
    public function testVerificarCarregamentoDaAcaoDeLogin()
    {
        $container = $this->prophesize(ContainerInterface::class);
        $container->get(AutenticacaoService::class)->willReturn(
            $this->prophesize(AutenticacaoService::class)->reveal()
        )->shouldBeCalled();

        $factory = new LoginAcaoFactory();
        $acao = $factory($container->reveal());

        $this->assertInstanceOf(LoginAcao::class, $acao);
    }
}
