<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Contato\ContatoService;
use ContatoModulo\Http\Acao\CadastrarContatoAcao;
use ContatoModulo\Modelo\Usuario;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class CadastrarContatoAcaoTest
 *
 * @package AppTest\ContatoModulo\Http\Acao
 * @group ContatoModulo
 */
class CadastrarContatoAcaoTest extends TestCase
{
    public function testCadastrarUmContatoCompleto()
    {
        $input = [
            'nome' => 'Alex Gomes',
            'setor' => 'GETEC',
            'ramalOuTelefone' => '3541',
        ];

        $output = [
            'id' => 1,
            'nome' => $input['nome'],
            'setor' => $input['setor'],
            'ramalOuTelefone' => $input['ramalOuTelefone'],
            'usuario' => (object)$this->getUsuario(),
            'createdAt' => '01/05/2017 00:00:00',
            'updatedAt' => '01/05/2017 00:00:00',
            'deletedAt' => '',
        ];

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getParsedBody()->willReturn($input)->shouldBeCalled();

        $servico = $this->prophesize(ContatoService::class);
        $servico->adicionarContato($input)->willReturn($output)->shouldBeCalled();

        $acao = new CadastrarContatoAcao($servico->reveal());
        $response = $acao->process(
            $request->reveal(),
            $this->prophesize(DelegateInterface::class)->reveal()
        );

        $resultado = (array)json_decode((string)$response->getBody());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($output, $resultado);
    }

    /**
     * Obtém o usuário de teste
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
            'createdAt' => '01/01/2017 00:00:00',
            'updatedAt' => '01/01/2017 00:00:00',
            'deletedAt' => null,
        ];
    }
}
