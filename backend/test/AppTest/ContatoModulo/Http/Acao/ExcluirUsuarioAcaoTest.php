<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Http\Acao;

use ContatoModulo\Http\Acao\ExcluirUsuarioAcao;
use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class ExcluirUsuarioAcaoTest
 *
 * @package AppTest\ContatoModulo\Aplicacao\Http\Acao
 * @author Alex Gomes <alexrsg@gmail.com>
 *
 * @group ContatoModulo
 */
class ExcluirUsuarioAcaoTest extends TestCase
{
    public function testExcluirUsuarioAPartirDoId()
    {
        $id = 1;
        $output = true;

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getAttribute('id')->willReturn($id)->shouldBeCalled();

        $servico = $this->prophesize(UsuarioServico::class);
        $servico->excluirUsuario($id)->willReturn($output)->shouldBeCalled();

        $acao = new ExcluirUsuarioAcao($servico->reveal());
        $response = $acao->process(
            $request->reveal(),
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        $resultado = json_decode((string)$response->getBody());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($output, $resultado);
    }
}
