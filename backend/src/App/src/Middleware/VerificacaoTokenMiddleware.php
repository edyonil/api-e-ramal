<?php
declare(strict_types=1);

namespace App\Middleware;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoJWT;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class VerificacaoTokenMiddleware
 *
 * @package App\Middleware
 * @author Alex Gomes <alexrsg@gmail.com>
 */
class VerificacaoTokenMiddleware implements MiddlewareInterface
{
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        try {
            if ($this->validarToken($request)) {
                return $delegate->process($request);
            }

            return new JsonResponse(['message' => 'Token não informado.'], 400);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
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

        list($token) = sscanf($input['0'], 'Bearer %s');

        if (is_null($token)) {
            return false;
        }

        $jwt = new AutenticacaoJWT();

        return $jwt->extrairDados($token) ? true : false;
    }
}
