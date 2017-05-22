<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoJWT;
use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoService;
use ContatoModulo\Http\Acao\LoginAcao;
use ContatoModulo\Modelo\Usuario;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class LoginAcaoTest
 *
 * @package AppTest\ContatoModulo\Http\Acao
 * @author Alex Gomes <alexrsg@gmail.com>
 *
 * @group ContatoModulo
 */
class LoginAcaoTest extends TestCase
{
    public function testFazerLogin()
    {
        $input = [
            'email' => 'alexrsg@gmail.com',
            'password' => 'xyz123',
        ];

        $output = [
            'token' => $this->getToken(),
        ];

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getParsedBody()->willReturn($input)->shouldBeCalled();

        $autenticacao = $this->prophesize(AutenticacaoService::class);
        $autenticacao->login($input['email'], $input['password'])->willReturn($output)->shouldBeCalled();

        $acao = new LoginAcao($autenticacao->reveal());
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
        $autenticacao = new AutenticacaoJWT();

        return $autenticacao->getToken($this->getUsuario())['token'];
    }

    /**
     * Inicializa um usuário de teste
     *
     * @return Usuario
     */
    protected function getUsuario(): Usuario
    {
        $hoje = new \DateTime();

        $usuario = new Usuario();

        $usuario->setNome('Alex Gomes')
            ->setEmail('alexrsg@gmail.com')
            ->setPassword('xyz123')
            ->setAtivo(true)
            ->setCompartilharContatos(true)
            ->setPrimeiroAcesso(true)
            ->setUpdatedAt($hoje)
            ->setCreatedAt($hoje);

        return $usuario;
    }
}
