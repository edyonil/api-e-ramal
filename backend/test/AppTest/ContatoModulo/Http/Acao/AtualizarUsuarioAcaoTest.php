<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Http\Acao;

use ContatoModulo\Http\Acao\AtualizarUsuarioAcao;
use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class AtualizarUsuarioAcaoTest
 *
 * @package AppTest\ContatoModulo\Aplicacao\Http\Acao
 * @author Alex Gomes <alexrsg@gmail.com>
 *
 * @group ContatoModulo
 */
class AtualizarUsuarioAcaoTest extends TestCase
{
    public function testAtualizarUsuario()
    {
        $input = [
            'nome' => 'Alexsandro Gomes',
            'email' => 'alexrsg.n95@gmail.com',
            'password' => '123xyz',
            'compartilharContatos' => false,
        ];

        $output = [
            'id' => 1,
            'nome' => 'Alexsandro Gomes',
            'email' => 'alexrsg.n95@gmail.com',
            'ativo' => true,
            'primeiroAcesso' => true,
            'compartilharContatos' => false,
            'createdAt' => '03/12/2015 00:00:00',
            'updatedAt' => '10/12/2015 00:00:00',
            'deletedAt' => null,
        ];

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getAttribute('id')->willReturn($output['id'])->shouldBeCalled();
        $request->getParsedBody()->willReturn($input)->shouldBeCalled();

        $servico = $this->prophesize(UsuarioServico::class);
        $servico->editarUsuario($output['id'], $input)->willReturn($output)->shouldBeCalled();

        $acao = new AtualizarUsuarioAcao($servico->reveal());
        $response = $acao->process(
            $request->reveal(),
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        $resultado = (array)json_decode((string)$response->getBody());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($output, $resultado);
    }
}
