<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Contato\ContatoService;
use ContatoModulo\Http\Acao\ContatoAcaoFactory;
use ContatoModulo\Http\Acao\ListarContatoAcao;
use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class ContatoAcaoFactoryTest
 *
 * @package AppTest\ContatoModulo\Http\Acao
 * @group ContatoModulo
 */
class ContatoAcaoFactoryTest extends TestCase
{
    public function testVerificarInstanciaDaClasseDoServico()
    {
        $contato = $this->prophesize(ContatoService::class);

        $container = $this->prophesize(ContainerInterface::class);
        $container->get(ContatoService::class)->willReturn($contato->reveal())->shouldBeCalled();

        $nomeDaClasse = ListarContatoAcao::class;

        $factory = new ContatoAcaoFactory();

        $acao = $factory($container->reveal(), $nomeDaClasse);

        $this->assertInstanceOf(ListarContatoAcao::class, $acao);
    }
}
