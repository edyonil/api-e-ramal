<?php
declare(strict_types=1);

namespace ContatoModulo\Aplicacao\Autenticacao;

use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioAutenticacaoRepositorio;
use Interop\Container\ContainerInterface;

/**
 * Class AutenticacaoServiceFactory
 *
 * @package ContatoModulo\Aplicacao\Autenticacao
 * @author Alex Gomes <alexrsg@gmail.com>
 */
class AutenticacaoServiceFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AutenticacaoService(
            $container->get(AutenticacaoJWT::class),
            $container->get(UsuarioAutenticacaoRepositorio::class)
        );
    }
}
