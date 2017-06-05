<?php
declare(strict_types=1);

namespace AppTest\Middleware;

use App\Middleware\VerificacaoTokenMiddleware;
use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoJWT;
use ContatoModulo\Modelo\Usuario;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class VerificacaoTokenMiddlewareTest
 *
 * @package AppTest\Middleware
 */
class VerificacaoTokenMiddlewareTest extends TestCase
{
    public function testVerificarRequisaoPossuiToken()
    {
        $tokenTeste = $this->getToken();

        $outputRequest = [
            "Bearer {$tokenTeste['token']}"
        ];

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getHeader('authorization')->willReturn($outputRequest)->shouldBeCalled();

        $delegate = $this->prophesize(DelegateInterface::class);
        $delegate->process($request->reveal())->willReturn($request->reveal())->shouldBeCalled();

        $middleware = new VerificacaoTokenMiddleware();
        $response = $middleware->process($request->reveal(), $delegate->reveal());

        $this->assertEquals($request->reveal(), $response);
    }

    /**
     * Obtém um token de teste
     *
     * @return array
     */
    protected function getToken(): array
    {
        $autenticacao = new AutenticacaoJWT();

        return $autenticacao->getToken($this->getUsuario());
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
