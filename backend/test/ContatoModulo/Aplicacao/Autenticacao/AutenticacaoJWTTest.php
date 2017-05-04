<?php declare(strict_types = 1);

namespace AppTest\ContatoModulo\Aplicacao\Autenticacao;

use PHPUnit\Framework\TestCase;
use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoJWT;
use ContatoModulo\Modelo\Usuario;
/**
 * @group Autenticacao/JWT
 */
class AutenticacaoJWTTest extends TestCase
{
    public function testGerarToken()
    {
        $jwtToken = new AutenticacaoJWT();
        $token = $jwtToken->getToken($this->usuario());
        $tokenArray = explode('.', $token['token']);

        $this->assertCount(3, $tokenArray);
        return $token['token'];
    }

    /**
     * @depends testGerarToken
     */
    public function testObterDadosLimpoDoToken($token)
    {
        $usuario = $this->usuario();
        $jwtToken = new AutenticacaoJWT();
        $dados = $jwtToken->extrairDados($token);

        $this->assertEquals($dados->data->id, $usuario->getId());
        $this->assertEquals($dados->data->email, $usuario->getEmail());
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
}
