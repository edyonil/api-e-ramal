<?php
declare(strict_types=1);

namespace ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Contato\ContatoService;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class ExcluirContatoAcao
 *
 * @package ContatoModulo\Http\Acao
 * @author Alex Gomes <alexrsg@gmail.com>
 */
class ExcluirContatoAcao implements MiddlewareInterface
{
    /**
     * @var ContatoService
     */
    protected $servico;

    /**
     * ExcluirContatoAcao constructor.
     *
     * @param ContatoService $contatoService
     */
    public function __construct(ContatoService $contatoService)
    {
        $this->servico = $contatoService;
    }

    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        try {

            return new JsonResponse([$this->servico->excluirContato((int)$request->getAttribute('id'))]);
        } catch (\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
    }
}
