<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use ContatoModulo\Http\Acao\ListarUsuarioAcao;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class ListarUsuarioAcaoTest
 *
 * @package AppTest\ContatoModulo\Http\Acao
 * @author Alex Gomes <alexrsg@gmail.com>
 *
 * @group ContatoModulo
 */
class ListarUsuarioAcaoTest extends TestCase
{
    public function testListarTodosOsUsuariosCadastrados()
    {
        $input = [];

        $output = [
            'itens' => [
                (object)$this->getUsuario(),
                (object)$this->getUsuario(),
                (object)$this->getUsuario(),
            ],
            'total' => 3,
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

    /**
     * @return array
     */
    protected function getUsuario(): array
    {
        return [
            'id' => 1,
            'nome' => 'Alex Gomes',
            'email' => 'alexrsg@gmail.com',
            'ativo' => true,
            'primeiroAcesso' => false,
            'compartilharContatos' => true,
            'createdAt' => '03/12/2015 00:00:00',
            'updatedAt' => '10/12/2015 00:00:00',
            'deletedAt' => null,
        ];
    }
}
