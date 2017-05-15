<?php
declare(strict_types=1);

namespace ContatoModulo\Aplicacao\Http\Acao;

use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

class ListarUsuarioAcao implements MiddlewareInterface
{
    private $usuarioServico;

    public function __construct(UsuarioServico $usuarioServico)
    {
        $this->usuarioServico = $usuarioServico;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        var_dump('all');die;
    }
}
