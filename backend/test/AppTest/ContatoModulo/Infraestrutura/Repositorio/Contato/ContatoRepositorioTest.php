<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 27/04/17
 * Time: 16:43
 */

namespace AppTest\ContatoModulo\Infraestrutura\Repositorio\Contato;

use AppTest\ContatoModulo\Infraestrutura\Repositorio\AbstractRepositorio;
use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use ContatoModulo\Infraestrutura\Persistencia\Contato\Repositorio\ContatoRepositorio;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioRepositorio;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

/**
 * Class ContatoRepositorioTest
 *
 * @package ContatoModulo\Infraestrutura\Repositorio\Contato
 *
 * @group ModuloContato/Repositorio
 */
class ContatoRepositorioTest extends AbstractRepositorio
{
    public static function setUpBeforeClass()
    {
        self::criarUmUsuario();
    }

    public static function tearDownAfterClass()
    {
        self::deleteUsuario();
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

    public function testAvaliaSeFuncionaContainer()
    {
        $this->assertInstanceOf(ContainerInterface::class, self::$container);
    }

    private function repositorio()
    {
        $entityManager = $this->container->get(EntityManager::class);
        return new ContatoRepositorio($entityManager);
    }

    private function obterUsuarioBanco()
    {
        $em = self::obterContainer(EntityManager::class);
        $repositorio = new UsuarioRepositorio($em);

        return $repositorio->encontrar(self::$usuario['id']);
    }

    private function criarUmUsuario()
    {
        $servico = self::obterContainer(UsuarioServico::class);

        self::$usuario = $servico->adicionarUsuario(self::data());
    }
}
