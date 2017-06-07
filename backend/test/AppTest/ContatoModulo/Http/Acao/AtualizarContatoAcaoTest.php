<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Contato\ContatoService;
use ContatoModulo\Http\Acao\AtualizarContatoAcao;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class AtualizarContatoAcaoTest
 *
 * @package AppTest\ContatoModulo\Http\Acao
 * @group ContatoModulo
 */
class AtualizarContatoAcaoTest extends TestCase
{
    public function testAtualizarUmContato()
    {
        $input = [
            'nome' => 'Alexsandro Gomes',
            'setor' => 'SEDEN',
            'ramalOuTelefone' => '3411',
        ];

        $output = [
            'id' => 1,
            'nome' => $input['nome'],
            'setor' => $input['setor'],
            'ramalOuTelefone' => $input['ramalOuTelefone'],
            'usuario' => (object)$this->getUsuario(),
            'createdAt' => '01/05/2017 00:00:00',
            'updatedAt' => '10/05/2017 00:00:00',
            'deletedAt' => '',
        ];

        $token = $this->getToken();

        $request = $this->prophesize(ServerRequestInterface::class);

        $request->getParsedBody()->willReturn($input)->shouldBeCalled();
        $request->getAttribute('id')->willReturn($output['id'])->shouldBeCalled();
        $request->getAttribute('token')->willReturn($token)->shouldBeCalled();

        $input['id'] = $output['id'];
        $input['token'] = $token;

        $servico = $this->prophesize(ContatoService::class);
        $servico->editarContato($output['id'], $input)->willReturn($output)->shouldBeCalled();

        $acao = new AtualizarContatoAcao($servico->reveal());

        $response = $acao->process(
            $request->reveal(),
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        $resultado = (array)json_decode((string)$response->getBody());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($output, $resultado);
    }

    /**
     * Obtém um token de teste
     *
     * @return string
     */
    protected function getToken(): string
    {
        return 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE0OTY4Njg3NzMsImV4cCI6MTQ5Njg3MjM3MywibmJmIjoxNDk2ODY4NzcyLCJkYXRhIjp7ImlkIjpudWxsLCJlbWFpbCI6ImFsZXhyc2dAZ21haWwuY29tIn19._ZPkksjSbTTBqS7xFh_r3AlIJ2LzLaayt9qUXW3lmmY';
    }

    /**
     * Inicializa um usuário de teste
     *
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
