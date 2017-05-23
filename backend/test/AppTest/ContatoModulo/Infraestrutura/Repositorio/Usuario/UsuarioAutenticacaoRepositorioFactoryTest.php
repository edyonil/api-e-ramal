<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Infraestrutura\Repositorio\Usuario;

use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioAutenticacaoRepositorio;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

/**
 * Class UsuarioAutenticacaoRepositorioFactoryTest
 *
 * @package AppTest\ContatoModulo\Infraestrutura\Repositorio\Usuario
 * @author Alex Gomes <alexrsg@gmail.com>
 *
 * @group ContatoModulo
 */
class UsuarioAutenticacaoRepositorioFactoryTest extends TestCase
{
    public function testVerificarCarregamentoDoRepositorio()
    {
        $em = $this->prophesize(EntityManager::class);

        $repositorio = new UsuarioAutenticacaoRepositorio($em->reveal());

        $this->assertInstanceOf(UsuarioAutenticacaoRepositorio::class, $repositorio);
    }
}
