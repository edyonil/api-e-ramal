<?php
declare(strict_types=1);

namespace App\Middleware;

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
        $input = $request->getParsedBody();

        if (!isset($input['token'])) {
            return new JsonResponse(['message' => 'Token não informado.'], 400);
        }

        return $delegate->process($request);
    }
}
