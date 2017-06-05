<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Contato\ContatoService;
use ContatoModulo\Http\Acao\ListarContatoAcao;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class ListarContatoAcaoTest
 *
 * @package AppTest\ContatoModulo\Http\Acao
 * @group ContatoModulo
 */
class ListarContatoAcaoTest extends TestCase
{
    public function testObterListaDeContatosCadastrados()
    {
        $input = [];

        $output = [
            'itens' => [
                (object)$this->getContato(),
                (object)$this->getContato(),
                (object)$this->getContato(),
            ],
            'total' => 3,
        ];

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getQueryParams()->willReturn($input)->shouldBeCalled();

        $delegate = $this->prophesize(DelegateInterface::class);

        $servico = $this->prophesize(ContatoService::class);
        $servico->listarContato($input)->willReturn($output)->shouldBeCalled();

        $acao = new ListarContatoAcao($servico->reveal());
        $response = $acao->process(
            $request->reveal(),
            $delegate->reveal()
        );

        $resultado = (array)json_decode((string)$response->getBody());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($output, $resultado);
    }

    /**
     * @return array
     */
    protected function getContato()
    {
        return [
            'id' => 1,
            'nome' => 'Alex Gomes',
            'setor' => 'GETEC',
            'ramalOuTelefone' => '3411',
            'usuario' => (object)$this->getUsuario(),
        ];
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
            'createdAt' => '01/01/2017 00:00:00',
            'updatedAt' => '01/01/2017 00:00:00',
            'deletedAt' => null,
        ];
    }
}
