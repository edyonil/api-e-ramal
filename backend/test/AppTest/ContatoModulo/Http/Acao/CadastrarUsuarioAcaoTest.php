<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Http\Acao;

use ContatoModulo\Http\Acao\CadastrarUsuarioAcao;
use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class CadastrarUsuarioAcaoTest
 *
 * @package AppTest\ContatoModulo\Aplicacao\Http\Acao
 * @author Alex Gomes <alexrsg@gmail.com>
 *
 * @group ContatoModulo
 */
class CadastrarUsuarioAcaoTest extends TestCase
{
    public function testCadastrarUsuarioCompleto()
    {
        $input = [
            'nome' => 'Alex Gomes',
            'email' => 'alexrsg@gmail.com',
            'password' => 'xyz123',
            'compartilharContatos' => true,
        ];

        $output = [
            'id' => 1,
            'nome' => 'Alex Gomes',
            'email' => 'alexrsg@gmail.com',
            'ativo' => true,
            'primeiroAcesso' => true,
            'compartilharContatos' => true,
            'createdAt' => '03/12/2015 00:00:00',
            'updatedAt' => '03/12/2015 00:00:00',
            'deletedAt' => null,
        ];

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getParsedBody()->willReturn($input)->shouldBeCalled();

        $servico = $this->prophesize(UsuarioServico::class);
        $servico->adicionarUsuario($input)->willReturn($output)->shouldBeCalled();

        $acao = new CadastrarUsuarioAcao($servico->reveal());
        $response = $acao->process(
            $request->reveal(),
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        $resultado = (array)json_decode((string)$response->getBody());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($output, $resultado);
    }
}
