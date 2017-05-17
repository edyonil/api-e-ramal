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
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Contato\ContatoRepositorio;
use ContatoModulo\Modelo\Contato;
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

    protected static $usuario;

    public static function setUpBeforeClass()
    {
        self::criarUmUsuario();
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

    private function dadosUsuario()
    {
        return [
            'nome' => 'EdyOnil',
            'setor' => 'DIRAF',
            'ramalOuTelefone' => '3117'
        ];
    }

    public function testAvaliaSeFuncionaContainer()
    {
        $this->assertInstanceOf(ContainerInterface::class, self::$container);
    }

    public function testCriarContato()
    {
        $data = $this->dadosUsuario();
        $contato = new Contato();
        $contato->setNome($data['nome'])
                ->setSetor($data['setor'])
                ->setRamalOuTelefone($data['ramalOuTelefone'])
                ->setUsuario($this->obterUsuarioBanco());

        $repositorio = $this->repositorio();
        $contatoAdicionado = $repositorio->adicionar($contato);

        $this->assertInstanceOf(Contato::class, $contatoAdicionado);

        return $contatoAdicionado;
    }

    /**
     * @depends testCriarContato
     */
    public function testAtualizarContato($contato)
    {
        $contato->setNome('EdyBorges');

        $repositorio = $this->repositorio();
        $contatoAdicionado = $repositorio->atualizar($contato);

        $this->assertInstanceOf(Contato::class, $contatoAdicionado);
    }

    /**
     * @depends testCriarContato
     */
    public function testLocalizarContato($contato)
    {
        $repositorio = $this->repositorio();
        $contatoAdicionado = $repositorio->encontrar($contato->getId());

        $this->assertInstanceOf(Contato::class, $contatoAdicionado);
    }

    public function testLocalizarTodosOsContatosDeUmUsuario()
    {
        $repositorio = $this->repositorio();
        $usuario = $this->obterUsuarioBanco()->getId();
        $contatoAdicionado = $repositorio->listar(['usuario' => $usuario]);

        $this->assertTrue(count($contatoAdicionado) > 0);
    }

    /**
     * @depends testCriarContato
     */
    public function testRemoverContato($contato)
    {

        $repositorio = $this->repositorio();
        $contatoExcluido = $repositorio->excluir($contato);

        $this->assertTrue($contatoExcluido);
    }

    /**
    * @depends testCriarContato
    * @expectedException Doctrine\ORM\NoResultException
    */
    public function testLocalizarContatoRemovido($contato)
    {
        $repositorio = $this->repositorio();
        $contatoAdicionado = $repositorio->encontrar($contato->getId());
    }

    private function repositorio()
    {
        $entityManager = self::obterContainer(EntityManager::class);
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

    private function deleteUsuario()
    {
        $servico = self::obterContainer(UsuarioServico::class);

        $servico->excluirUsuario(self::$usuario['id']);
    }
}
