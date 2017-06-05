<?php
declare(strict_types=1);

namespace ContatoModulo\Infraestrutura\Container\Aplicacao\Contato;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoJWT;
use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoService;
use ContatoModulo\Aplicacao\Contato\ContatoService;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Contato\ContatoRepositorio;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioAutenticacaoRepositorio;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;

/**
 * Class ContatoServicoFactory
 *
 * @package ContatoModulo\Infraestrutura\Container\Aplicacao\Contato
 * @author Alex Gomes <alexrsg@gmail.com>
 */
class ContatoServicoFactory
{
    /**
     * @param ContainerInterface $container
     * @return ContatoService
     */
    public function __invoke(ContainerInterface $container)
    {
        return new ContatoService(
            new ContatoRepositorio($container->get(EntityManager::class)),
            new AutenticacaoService(
                $container->get(AutenticacaoJWT::class),
                $container->get(UsuarioAutenticacaoRepositorio::class)
            )
        );
    }
}
