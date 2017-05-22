<?php
declare(strict_types=1);

namespace ContatoModulo;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoJWT;
use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoJWTFactory;
use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoService;
use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoServiceFactory;
use ContatoModulo\Http\Acao\AtualizarUsuarioAcao;
use ContatoModulo\Http\Acao\CadastrarUsuarioAcao;
use ContatoModulo\Http\Acao\ExcluirUsuarioAcao;
use ContatoModulo\Http\Acao\ListarUsuarioAcao;
use ContatoModulo\Http\Acao\LoginAcao;
use ContatoModulo\Http\Acao\LoginAcaoFactory;
use ContatoModulo\Http\Acao\ObterUsuarioAcao;
use ContatoModulo\Http\Acao\UsuarioAcaoFactory;
use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use ContatoModulo\Infraestrutura\Container\Aplicacao\Usuario\UsuarioServicoFactory;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioAutenticacaoRepositorio;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioAutenticacaoRepositorioFactory;

/**
 * The configuration provider for the ContatoModulo module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => $this->getDependencies(),
            // 'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            'invokables' => [
            ],
            'factories'  => [
                // Usuário
                UsuarioServico::class => UsuarioServicoFactory::class,
                ListarUsuarioAcao::class => UsuarioAcaoFactory::class,
                ObterUsuarioAcao::class => UsuarioAcaoFactory::class,
                CadastrarUsuarioAcao::class => UsuarioAcaoFactory::class,
                AtualizarUsuarioAcao::class => UsuarioAcaoFactory::class,
                ExcluirUsuarioAcao::class => UsuarioAcaoFactory::class,
                // Login
                LoginAcao::class => LoginAcaoFactory::class,
                AutenticacaoService::class => AutenticacaoServiceFactory::class,
                AutenticacaoJWT::class => AutenticacaoJWTFactory::class,
                UsuarioAutenticacaoRepositorio::class => UsuarioAutenticacaoRepositorioFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     *
     * @return array
     */
    public function getTemplates()
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
