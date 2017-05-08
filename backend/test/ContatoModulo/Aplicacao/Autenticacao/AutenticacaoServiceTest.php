<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 02/05/17
 * Time: 12:51
 */

namespace AppTest\ContatoModulo\Aplicacao\Autenticacao;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoService;
use ContatoModulo\Aplicacao\Autenticacao\TipoAutenticacaoInterface;
use ContatoModulo\Aplicacao\Excecao\UsuarioException;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioAutenticacaoRepositorio;
use ContatoModulo\Modelo\Usuario;
use PHPUnit\Framework\TestCase;

/**
 * Class AutenticacaoServiceTest
 *
 * @package AppTest\ContatoModulo\Aplicacao\Autenticacao
 *
 * @group Autenticacao
 */
class AutenticacaoServiceTest extends TestCase
{
    public function testLogin()
    {
        $email = 'edyonil@gmail.com';
        $password = '123456';

        $repositorio = $this->prophesize(UsuarioAutenticacaoRepositorio::class);

        $repositorio->getUsuario($email, $password)
            ->willReturn($this->usuario())
            ->shouldBeCalled();

        $tipo = $this->prophesize(TipoAutenticacaoInterface::class);

        $tipo->getToken($this->usuario())
            ->willReturn(
                [
                    'login' => true,
                    'token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9
            .eyJpYXQiOjE0NzA2MDczMDAsImlzcyI6ImRvdWdsYXNwYXNxdWEuY29tIiwiZXhwIjox
            NDcwNjEwOTAwLCJuYmYiOjE0NzA2MDcyOTksImRhdGEiOnsiaWQiOjEsIm5hbWUiOiJEb3
            VnbGFzIFBhc3F1YSJ9fQ.WuT3TRLqUkzOgDdEr1YiQdXhz0OvwMDTzYpeKDDFDAY'
                ]
            )->shouldBeCalled();

        $autServ = new AutenticacaoService($tipo->reveal(), $repositorio->reveal());

        $token = $autServ->login($email, $password);

        $this->assertArrayHasKey('token', $token);

        $tokenArray = explode('.', $token['token']);

        $this->assertCount(3, $tokenArray);

    }

    /**
     * @expectedException ContatoModulo\Aplicacao\Excecao\UsuarioException
     */
    public function testLoginComUsuarioInativo()
    {
        $email = 'edyonil@gmail.com';
        $password = '123456';

        $repositorio = $this->prophesize(UsuarioAutenticacaoRepositorio::class);

        $repositorio->getUsuario($email, $password)
            ->willReturn($this->usuarioInativo())
            ->shouldBeCalled();

        $tipo = $this->prophesize(TipoAutenticacaoInterface::class);

        $autServ = new AutenticacaoService($tipo->reveal(), $repositorio->reveal());

        $autServ->login($email, $password);

    }

    /**
     * @expectedException ContatoModulo\Aplicacao\Excecao\UsuarioException
     */
    public function testLoginComUsuarioOuSenhaInvalido()
    {
        $email = 'edyonil@gmail.com';
        $password = '34567';

        $repositorio = $this->prophesize(UsuarioAutenticacaoRepositorio::class);

        $repositorio->getUsuario($email, $password)
            ->willReturn(null)
            ->shouldBeCalled();

        $tipo = $this->prophesize(TipoAutenticacaoInterface::class);

        $autServ = new AutenticacaoService($tipo->reveal(), $repositorio->reveal());

        $autServ->login($email, $password);

    }

    private function usuario()
    {
        $usuario = new Usuario();

        $usuario->setNome('edy')
            ->setEmail('edyonil@gmail.com')
            ->setAtivo(true)
            ->setPrimeiroAcesso(false)
            ->setCompartilharContatos(true)
            ->setCreatedAt('2017-12-01 09:20:12')
            ->setUpdatedAt('2017-12-01 09:20:12')
            ->setDeletedAt(null);

        return $usuario;
    }

    private function usuarioInativo()
    {
        $usuario = new Usuario();

        $usuario->setNome('edy')
            ->setEmail('edyonil@gmail.com')
            ->setAtivo(false)
            ->setPrimeiroAcesso(false)
            ->setCompartilharContatos(true)
            ->setCreatedAt('2017-12-01 09:20:12')
            ->setUpdatedAt('2017-12-01 09:20:12')
            ->setDeletedAt(null);

        return $usuario;
    }

    private function creiarUsuario()
    {

    }

}
