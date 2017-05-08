<?php
declare(strict_types=1);

namespace Test\ContatoModulo\Infraestrutura\Container\Aplicacao\Usuario;

use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use ContatoModulo\Infraestrutura\Container\Aplicacao\Usuario\UsuarioServicoFactory;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class UsuarioServicoFactoryTest
 *
 * @package Test\ContatoModulo\Infraestrutura\Container\Aplicacao\Usuario
 * @group ContatoModulo/Factory
 */
class UsuarioServicoFactoryTest extends TestCase
{
    public function testCarragarFactory()
    {
        $containerInterface = $this->prophesize(ContainerInterface::class);

        $containerInterface
            ->get(EntityManager::class)
            ->willReturn($this->prophesize(EntityManager::class)->reveal());

        $usuarioServicoFactory = (new UsuarioServicoFactory())($containerInterface->reveal());

        $this->assertInstanceOf(UsuarioServico::class, $usuarioServicoFactory);
    }
}
