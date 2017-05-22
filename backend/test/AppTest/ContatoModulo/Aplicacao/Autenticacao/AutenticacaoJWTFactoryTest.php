<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Autenticacao;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoJWT;
use PHPUnit\Framework\TestCase;

/**
 * Class AutenticacaoJWTFactoryTest
 *
 * @package AppTest\ContatoModulo\Autenticacao
 * @author Alex Gomes <alexrsg@gmail.com>
 *
 * @group ContatoModulo
 */
class AutenticacaoJWTFactoryTest extends TestCase
{
    public function testVerificarCarregamentoDaAutenticacao()
    {
        $autenticacao = new AutenticacaoJWT();

        $this->assertInstanceOf(AutenticacaoJWT::class, $autenticacao);
    }
}
