<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Infraestrutura\Repositorio\Usuario;

use AppTest\ContatoModulo\Infraestrutura\Repositorio\AbstractRepositorio;
use ContatoModulo\Aplicacao\Usuario\UsuarioServico;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioAutenticacaoRepositorio;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioRepositorio;
use Doctrine\ORM\EntityManager;

/**
 * Class UsuarioAutenticacaoRepositorioTest
 *
 * @package AppTest\ContatoModulo\Infraestrutura\Repositorio\Usuario
 * @author Alex Gomes <alexrsg@gmail.com>
 */
class UsuarioAutenticacaoRepositorioTest extends AbstractRepositorio
{
    /**
     * @var array
     */
    protected $usuario;

    /**
     * @var UsuarioServico
     */
    protected $servico;

    /**
     * Cadastra o usuário de teste
     */
    protected function setUp()
    {
        parent::setUp();

        $this->obterServico();
        $this->criarUsuario();
    }

    /**
     * Teste para obter o usuário a partir do login/senha
     */
    public function testObterUsuarioAPartirDoLoginESenha()
    {
        $email = 'alexrsg@gmail.com';
        $senha = 'xyz123';

        $outputRepo = $this->obterUsuario();

        $em = self::obterContainer(EntityManager::class);
        $repositorio = new UsuarioAutenticacaoRepositorio($em);
        $usuario = $repositorio->getUsuario($email, $senha);

        $this->assertEquals($usuario, $outputRepo);
    }

    /**
     * Inicializa o serviço do usuário
     */
    protected function obterServico()
    {
        $this->servico = $this->obterContainer(UsuarioServico::class);
    }

    /**
     * @return array
     */
    protected function dadosUsuario()
    {
        return [
            'nome' => 'Alex Gomes',
            'email' => 'alexrsg@gmail.com',
            'password' => 'xyz123',
            'compartilharContatos' => true,
            'primeiroAcesso' => true,
        ];
    }

    /**
     * Cadastra o usuário no banco
     */
    protected function criarUsuario()
    {
        $this->usuario = $this->servico->adicionarUsuario($this->dadosUsuario());
    }

    /**
     * Obtém o usuário cadastrado
     *
     * @return \ContatoModulo\Modelo\ModeloInterface
     */
    protected function obterUsuario()
    {
        $repo = new UsuarioRepositorio($this->obterContainer(EntityManager::class));

        return $repo->encontrar($this->usuario['id']);
    }

    /**
     * Remove o usuário do banco
     */
    protected function removerUsuario()
    {
        $this->servico->excluirUsuario($this->usuario['id']);
    }

    /**
     * Remove o usuário de teste
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->removerUsuario();
    }
}
