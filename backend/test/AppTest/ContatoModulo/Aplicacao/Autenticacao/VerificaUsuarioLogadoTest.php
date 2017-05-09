<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Autenticacao\Aplicacao;

use AppTest\ContatoModulo\Infraestrutura\Repositorio\AbstractRepositorio;
use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoService;
use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoJWT;
use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioAutenticacaoRepositorio;
use Doctrine\ORM\EntityManager;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioRepositorio;
use ContatoModulo\Modelo\Usuario;
/**
 * @group VerificaLogin
 */
class VerificaUsuarioLogadoTest extends AbstractRepositorio
{

    public static $usuario;

    public static function setUpBeforeClass()
    {
        self::criarUmUsuario();
    }

    public static function tearDownAfterClass()
    {
        self::deleteUsuario();
    }

    public function testObterUsuarioLogado()
    {
        $token = $this->gerarToken();
        $autenticacao = new AutenticacaoService(
            new AutenticacaoJWT(),
            $this->repositorio()
        );

        $usuario = $autenticacao->obterUsuarioAutenticado($token);

        $this->assertInstanceOf(Usuario::class, $usuario);
    }

    private function gerarToken()
    {
        $jwtToken = new AutenticacaoJWT();
        $usuario = self::obterUsuarioBanco();
        $token = $jwtToken->getToken($usuario);

        $tokenArray = explode('.', $token['token']);

        return $token['token'];
    }

    private function criarUmUsuario()
    {
        $servico = self::obterContainer(UsuarioServico::class);

        self::$usuario = $servico->adicionarUsuario(self::data());
    }

    private function obterUsuarioBanco()
    {
        $em = self::obterContainer(EntityManager::class);
        $repositorio = new UsuarioRepositorio($em);

        return $repositorio->encontrar(self::$usuario['id']);
    }

    private function deleteUsuario()
    {
        $servico = self::obterContainer(UsuarioServico::class);

        $servico->excluirUsuario(self::$usuario['id']);
    }

    private function data()
    {
        return [
            'compartilharContatos' => true,
            'email' => 'edyonil@local.com',
            'password' => 1234567,
            'nome' => 'Edy Borges'
        ];
    }

    private function repositorio()
    {
        $em = self::obterContainer(EntityManager::class);
        return new UsuarioAutenticacaoRepositorio($em);
    }
}
