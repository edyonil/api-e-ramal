<?php
declare(strict_types=1);

namespace App\Middleware;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoJWT;
use ContatoModulo\Http\Acao\LoginAcao;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Router\RouteResult;

/**
 * Class VerificacaoTokenMiddleware
 *
 * @package App\Middleware
 * @author Alex Gomes <alexrsg@gmail.com>
 */
class VerificacaoTokenMiddleware implements MiddlewareInterface
{
    /**
     * @var string
     */
    protected $token;

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return \Psr\Http\Message\ResponseInterface|JsonResponse
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        try {

            if ($this->ehLogin($request)) {
                return $delegate->process($request);
            }

            if ($this->validarToken($request)) {
                $request = $request->withAttribute('token', $this->token);
            } else {
                $request = $request->withAttribute('erro', 'Token não informado.');
            }

            return $delegate->process($request);
        } catch (\Exception $e) {
            return new JsonResponse([$e->getMessage()], 400);
        }
    }

    /**
     * Valida o token informado
     *
     * @param ServerRequestInterface $request
     * @return bool
     */
    protected function validarToken(ServerRequestInterface $request): bool
    {
        $input = $request->getHeader('authorization');

        if (empty($input)) {
            return false;
        }

        list($this->token) = sscanf($input[0], 'Bearer %s');

        if (is_null($this->token)) {
            return false;
        }

        $jwt = new AutenticacaoJWT();

        return $jwt->extrairDados($this->token) ? true : false;
    }

    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    protected function ehLogin(ServerRequestInterface $request): bool
    {
        $route = $request->getAttribute(RouteResult::class, false);

        if ($route && $route->getMatchedMiddleware() == LoginAcao::class) {
            return true;
        }

        return false;
    }
}
