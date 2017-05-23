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

    private $input;

    public function __construct(AutenticacaoService $autenticacaoService)
    {
        $this->autenticacaoServico = $autenticacaoService;
    }

    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        try {

            $this->input = $request->getParsedBody();

            $this->validacao();

            return new JsonResponse($this->autenticacaoServico->login(
                $this->input['email'],
                $this->input['password'])
            );
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 400);
        }
    }

    /**
     * @throws \Exception
     */
    protected function validacao()
    {
        if (!isset($this->input['email'])) {
            throw new \Exception('O campo e-mail é obrigatório.');
        }

        if (!isset($this->input['password'])) {
            throw new \Exception('O campo password é obrigatório.');
        }
    }
}
