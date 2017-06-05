<?php
declare(strict_types=1);

namespace ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class ListarUsuarioAcao
 *
 * @package ContatoModulo\Aplicacao\Http\Acao
 * @author Alex Gomes <alexrsg@gmail.com>
 */
class ListarUsuarioAcao implements MiddlewareInterface
{
    /**
     * @var UsuarioServico
     */
    private $usuarioServico;

    /**
     * ListarUsuarioAcao constructor.
     *
     * @param UsuarioServico $usuarioServico
     */
    public function __construct(UsuarioServico $usuarioServico)
    {
        $this->usuarioServico = $usuarioServico;
    }

    /**
     * @param ServerRequestInterface $request
     * @param DelegateInterface $delegate
     * @return JsonResponse
     */
    public function process(
        ServerRequestInterface $request,
        DelegateInterface $delegate
    ) {
        try {

            return new JsonResponse($this->usuarioServico->listarUsuario($request->getQueryParams()));
        } catch (\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }
    }
}
