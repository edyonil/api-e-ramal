<?php
declare(strict_types=1);

namespace ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class CadastrarUsuarioAcao
 *
 * @package ContatoModulo\Aplicacao\Http\Acao
 * @author Alex Gomes <alexrsg@gmail.com>
 */
class CadastrarUsuarioAcao implements MiddlewareInterface
{
    /**
     * @var UsuarioServico
     */
    private $usuarioServico;

    /**
     * CadastrarUsuarioAcao constructor.
     *
     * @param UsuarioServico $usuarioServico
     */
    public function __construct(UsuarioServico $usuarioServico)
    {
        $this->usuarioServico = $usuarioServico;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        try {

            return new JsonResponse($this->usuarioServico->adicionarUsuario($request->getParsedBody()));
        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage(), 400);
        }
    }
}
