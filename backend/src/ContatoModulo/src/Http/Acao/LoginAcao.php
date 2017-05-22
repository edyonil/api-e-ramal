<?php
declare(strict_types=1);

namespace ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoService;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class LoginAcao
 *
 * @package AppTest\ContatoModulo\Http\Acao
 * @author Alex Gomes <alexrsg@gmail.com>
 */
class LoginAcao implements MiddlewareInterface
{
    private $autenticacaoServico;

    public function __construct(AutenticacaoService $autenticacaoService)
    {
        $this->autenticacaoServico = $autenticacaoService;
    }

    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        try {

            $input = $request->getParsedBody();

            return new JsonResponse($this->autenticacaoServico->login(
                $input['email'],
                $input['password'])
            );
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 400);
        }
    }
}
