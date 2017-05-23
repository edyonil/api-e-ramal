<?php
declare(strict_types=1);

namespace AppTest\Middleware;

use App\Middleware\VerificacaoTokenMiddleware;
use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoJWT;
use ContatoModulo\Modelo\Usuario;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class VerificacaoTokenMiddlewareTest
 *
 * @package AppTest\Middleware
 */
class VerificacaoTokenMiddlewareTest extends TestCase
{
    public function testVerificarToken()
    {
        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getParsedBody()->willReturn($this->getToken())->shouldBeCalled();

        $delegate = $this->prophesize(DelegateInterface::class);
        $delegate->process($request)->willReturn(ResponseInterface::class)->shouldBeCalled();

        $middleware = new VerificacaoTokenMiddleware();
        $response = $middleware->process($request->reveal(), $delegate->reveal());

        $this->assertInstanceOf(ResponseInterface::class, $response);
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
