<?php
declare(strict_types=1);

namespace AppTest\Middleware;

use App\Middleware\VerificacaoTokenMiddleware;
use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoJWT;
use ContatoModulo\Modelo\Usuario;
use Interop\Http\ServerMiddleware\DelegateInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Router\RouteResult;

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
            "Bearer {$tokenTeste}"
        ];

        $route = $this->prophesize(RouteResult::class);
        $route->getMatchedMiddleware()
            ->willReturn(VerificacaoTokenMiddleware::class)
            ->shouldBeCalled();

        $request = $this->prophesize(ServerRequestInterface::class);
        $request->getAttribute(RouteResult::class, false)
            ->willReturn($route->reveal())
            ->shouldBeCalled();

        $request->getHeader('authorization')
            ->willReturn($outputRequest)
            ->shouldBeCalled();

        $request->withAttribute('token', $tokenTeste)
            ->willReturn($request->reveal())
            ->shouldBeCalled();

        $delegate = $this->prophesize(DelegateInterface::class);
        $delegate->process($request->reveal())->willReturn($request->reveal())->shouldBeCalled();

        $middleware = new VerificacaoTokenMiddleware();
        $response = $middleware->process($request->reveal(), $delegate->reveal());

        $this->assertEquals($request->reveal(), $response);
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
