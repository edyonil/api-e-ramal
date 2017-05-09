<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Autenticacao\Aplicacao;

use AppTest\ContatoModulo\Infraestrutura\Repositorio\AbstractRepositorio;
use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoService;
use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoJWT;
use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioAutenticacaoRepositorio;
/**
 * @group VerificaLogin
 */
class VerificaUsuarioLogadoTest extends AbstractRepositorio
{

    public $usuario;

    public function setUp()
    {
        $this->criarUmUsuario();
    }

    public function tearDown()
    {
        $this->deleteUsuario();
    }

    private function gerarToken()
    {
        $jwtToken = new AutenticacaoJWT();
        $token = $jwtToken->getToken($this->usuario);

        $tokenArray = explode('.', $token['token']);

        return $token['token'];
    }

    /**
     * @depends gerarToken
     */
    public function testObterUsuarioLogado($token)
    {
        $token = $this->gerarToken();
        // $autenticacao = new AutenticacaoService(
        //     new AutenticacaoJWT(),
        //     $this->mockRepositorio()->
        // );
    }

    private function criarUmUsuario()
    {
        $servico = $this->container->get(UsuarioService::class);

        $this->usuario = $servico->adicionarUsuario($this->data());
    }

    private function deleteUsuario()
    {
        $servico = $this->container->get(UsuarioService::class);

        $servico->excluirUsuario($this->usuario['id']);
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

    private function mockRepositorio()
    {
        $repositorio = $this->prophesize(UsuarioAutenticacaoRepositorio::class);

        return $repositorio->getUsuario($email, $password)
            ->willReturn($this->usuario())
            ->shouldBeCalled();
    }
}
