<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Contato\ContatoService;
use ContatoModulo\Http\Acao\ExcluirContatoAcao;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class ExcluirContatoAcaoTest
 *
 * @package AppTest\ContatoModulo\Http\Acao
 * @group ContatoModulo
 */
class ExcluirContatoAcaoTest extends TestCase
{
    public function testExcluirUmContato()
    {
        $id = 1;
        $output = true;

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getAttribute('id')->willReturn($id)->shouldBeCalled();

        $delegate = $this->prophesize(DelegateInterface::class);

        $servico = $this->prophesize(ContatoService::class);
        $servico->excluirContato($id)->willReturn($output)->shouldBeCalled();

        $acao = new ExcluirContatoAcao($servico->reveal());
        $response = $acao->process(
            $request->reveal(),
            $delegate->reveal()
        );

        $resultado = (array)json_decode((string)$response->getBody());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals([$output], $resultado);
    }
}
