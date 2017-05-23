<?php
declare(strict_types=1);

namespace APpTest\ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use ContatoModulo\Http\Acao\ListarUsuarioAcao;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class ListarUsuarioAcaoTest
 *
 * @package APpTest\ContatoModulo\Http\Acao
 * @author Alex Gomes <alexrsg@gmail.com>
 *
 * @group ContatoModulo
 */
class ListarUsuarioAcaoTest extends TestCase
{
    public function testListarTodosOsUsuariosCadastrados()
    {
        $usuario = new \stdClass();
        $usuario->id = null;
        $usuario->nome = 'Alex Gomes';
        $usuario->email = 'alexrsg@gmail.com';
        $usuario->ativo = true;
        $usuario->primeiroAcesso = true;
        $usuario->compartilharContatos = false;
        $usuario->createdAt = '03/12/2015 00:00:00';
        $usuario->updatedAt = '10/12/2015 00:00:00';
        $usuario->deletedAt = null;

        $input = [];

        $output = [
            $usuario,
            clone $usuario,
            clone $usuario,
        ];

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getQueryParams()->willReturn($input)->shouldBeCalled();

        $servico = $this->prophesize(UsuarioServico::class);
        $servico->listarUsuario($input)->willReturn($output)->shouldBeCalled();

        $acao = new ListarUsuarioAcao($servico->reveal());
        $response = $acao->process(
            $request->reveal(),
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        $resultado = (array)json_decode((string)$response->getBody());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($output, $resultado);
    }
}
