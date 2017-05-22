<?php
declare(strict_types=1);

namespace ContatoModulo\Http\Acao;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoService;
use Interop\Container\ContainerInterface;

/**
 * Class LoginAcaoFactory
 *
 * @package ContatoModulo\Http\Acao
 * @author Alex Gomes <alexrsg@gmail.com>
 */
class LoginAcaoFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new LoginAcao($container->get(AutenticacaoService::class));
    }
}
