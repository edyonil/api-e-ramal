<?php
declare(strict_types=1);

use ContatoModulo\Infraestrutura\Persistencia\Repositorio\RepositorioInterface;
use ContatoModulo\Modelo\Usuario;
use PHPUnit\Framework\TestCase;
use ContatoModulo\Aplicacao\Usuario\UsuarioServico;

/**
 * Class UsuarioServicoTest
 *
 * @package AppTest\ContatoModulo\Aplicacao\Contato
 * @group ContatoModulo
 */
class UsuarioServicoTest extends TestCase
{
    /**
     * Testa o cadastro de usuário
     */
    public function testCadastrarUsuario()
    {
        $input = [
            'nome' => 'Alex Gomes',
            'email' => 'alexrsg@gmail.com',
            'password' => 'xyz123',
            'compartilharContatos' => false,
        ];

        $output = [
            'id' => null,
            'nome' => 'Alex Gomes',
            'email' => 'alexrsg@gmail.com',
            'ativo' => true,
            'primeiroAcesso' => true,
            'compartilharContatos' => false,
            'createdAt' => '03/12/2015 00:00:00',
            'updatedAt' => '03/12/2015 00:00:00',
            'deletedAt' => null,
        ];

        $inputRepo = new Usuario();
        $inputRepo->setAtivo(true)
            ->setCompartilharContatos(false)
            ->setDeletedAt(null)
            ->setEmail($input['email'])
            ->setNome($input['nome'])
            ->setPassword($input['password'])
            ->setPrimeiroAcesso(true);

        $outputRepo = clone $inputRepo;
        $outputRepo->setCreatedAt($this->criarDataCadastro())
            ->setUpdatedAt($this->criarDataCadastro());

        $repositorio = $this->prophesize(RepositorioInterface::class);
        $repositorio->adicionar($inputRepo)->willReturn($outputRepo);

        $usuarioServico = new UsuarioServico($repositorio->reveal());

        $resultado = $usuarioServico->adicionarUsuario($input);

        $this->assertEquals($resultado, $output);
    }

    /**
     * Testa a edição de usuário
     */
    public function testEditarUsuario()
    {
        $id = 1;

        $input = [
            'nome' => 'Alex Gomes',
            'email' => 'alexrsg@gmail.com',
            'password' => '123xyz',
            'ativo' => true,
            'compartilharContatos' => false,
            'primeiroAcesso' => false,
        ];

        $output = [
            'id' => null,
            'nome' => 'Alex Gomes',
            'email' => 'alexrsg@gmail.com',
            'ativo' => true,
            'primeiroAcesso' => false,
            'compartilharContatos' => false,
            'createdAt' => '03/12/2015 00:00:00',
            'updatedAt' => '10/12/2015 00:00:00',
            'deletedAt' => null,
        ];

        $inputRepo = new Usuario();
        $inputRepo->setAtivo(true)
            ->setCompartilharContatos(false)
            ->setCreatedAt($this->criarDataCadastro())
            ->setDeletedAt(null)
            ->setEmail($input['email'])
            ->setNome($input['nome'])
            ->setPassword($input['password'])
            ->setPrimeiroAcesso(false)
            ->setUpdatedAt($this->criarDataAtualizacao());

        $outputRepo = clone $inputRepo;
        $outputRepoEditar = clone $outputRepo;

        $repositorio = $this->prophesize(RepositorioInterface::class);

        $repositorio->encontrar($id)->willReturn($outputRepo);
        $repositorio->atualizar($inputRepo)->willReturn($outputRepoEditar);

        $usuarioServico = new UsuarioServico($repositorio->reveal());

        $resultado = $usuarioServico->editarUsuario($id, $input);

        $this->assertEquals($resultado, $output);
    }

    /**
     * Testa a busca de um usuário pelo id
     */
    public function testLocalizarUsuario()
    {
        $id = 1;

        $output = [
            'id' => null,
            'nome' => 'Alex Gomes',
            'email' => 'alexrsg@gmail.com',
            'ativo' => true,
            'primeiroAcesso' => true,
            'compartilharContatos' => false,
            'createdAt' => '03/12/2015 00:00:00',
            'updatedAt' => '10/12/2015 00:00:00',
            'deletedAt' => null,
        ];

        $outputRepo = new Usuario();

        $outputRepo->setNome($output['nome'])
            ->setEmail($output['email'])
            ->setAtivo($output['ativo'])
            ->setPrimeiroAcesso($output['primeiroAcesso'])
            ->setCompartilharContatos($output['compartilharContatos'])
            ->setCreatedAt($this->criarDataCadastro())
            ->setUpdatedAt($this->criarDataAtualizacao())
            ->setDeletedAt($output['deletedAt']);

        // Mock do repositório
        $repository = $this->prophesize(RepositorioInterface::class);

        $repository->encontrar($id)->willReturn($outputRepo);

        $usuarioServico = new UsuarioServico($repository->reveal());

        $resultado = $usuarioServico->localizarUsuario($id);

        $this->assertEquals($resultado, $output);
    }

    /**
     * Testa a listagem de usuários
     */
    public function testListarUsuariosComPaginacao()
    {
        $output = [
            [
                'id' => null,
                'nome' => 'Alex Gomes',
                'email' => 'alexrsg@gmail.com',
                'ativo' => true,
                'primeiroAcesso' => true,
                'compartilharContatos' => false,
                'createdAt' => '03/12/2015 00:00:00',
                'updatedAt' => '10/12/2015 00:00:00',
                'deletedAt' => null,
            ],
            [
                'id' => null,
                'nome' => 'Alex Gomes',
                'email' => 'alexrsg@gmail.com',
                'ativo' => true,
                'primeiroAcesso' => true,
                'compartilharContatos' => false,
                'createdAt' => '03/12/2015 00:00:00',
                'updatedAt' => '10/12/2015 00:00:00',
                'deletedAt' => null,
            ],
            [
                'id' => null,
                'nome' => 'Alex Gomes',
                'email' => 'alexrsg@gmail.com',
                'ativo' => true,
                'primeiroAcesso' => true,
                'compartilharContatos' => false,
                'createdAt' => '03/12/2015 00:00:00',
                'updatedAt' => '10/12/2015 00:00:00',
                'deletedAt' => null,
            ]
        ];

        $usuario = new Usuario();

        $usuario->setNome($output[0]['nome'])
            ->setEmail($output[0]['email'])
            ->setAtivo($output[0]['ativo'])
            ->setPrimeiroAcesso($output[0]['primeiroAcesso'])
            ->setCompartilharContatos($output[0]['compartilharContatos'])
            ->setCreatedAt($this->criarDataCadastro())
            ->setUpdatedAt($this->criarDataAtualizacao())
            ->setDeletedAt($output[0]['deletedAt']);

        $outputRepo = [
            clone $usuario,
            clone $usuario,
            clone $usuario,
        ];

        $input = [
            'page' => 1,
            'limit' => 2
        ];

        // Mock do repositório
        $repository = $this->prophesize(RepositorioInterface::class);

        $repository->listar($input)->willReturn($outputRepo);

        $usuarioServico = new UsuarioServico($repository->reveal());

        $resultado = $usuarioServico->listarUsuario($input);

        $this->assertEquals($resultado['itens'], $output);
        $this->assertCount(3, $resultado['itens']);
    }

    /**
     * Testa a exclusão de usuários
     */
    public function testExcluindoUmContato()
    {
        $id = 1;

        $output = [
            'id' => null,
            'nome' => 'Alex Gomes',
            'email' => 'alexrsg@gmail.com',
            'ativo' => true,
            'primeiroAcesso' => true,
            'compartilharContatos' => false,
            'createdAt' => '03/12/2015 00:00:00',
            'updatedAt' => '10/12/2015 00:00:00',
            'deletedAt' => null,
        ];

        $outputRepo = new Usuario();

        $outputRepo->setNome($output['nome'])
            ->setEmail($output['email'])
            ->setAtivo($output['ativo'])
            ->setPrimeiroAcesso($output['primeiroAcesso'])
            ->setCompartilharContatos($output['compartilharContatos'])
            ->setCreatedAt($this->criarDataCadastro())
            ->setUpdatedAt($this->criarDataAtualizacao())
            ->setDeletedAt($output['deletedAt']);

        // Mock do repositório
        $repository = $this->prophesize(RepositorioInterface::class);

        $repository->encontrar($id)->willReturn($outputRepo)->shouldBeCalled();

        $repository->excluir($outputRepo)->willReturn(true)->shouldBeCalled();

        $usuarioServico = new UsuarioServico($repository->reveal());

        $this->assertTrue($usuarioServico->excluirUsuario($id));
    }

    /**
     * Cria uma data para cadastro do registro
     *
     * @return \DateTime
     */
    protected function criarDataCadastro()
    {
        return new \DateTime('2015-12-03 00:00:00');
    }

    /**
     * Cria uma data para atualização do registro
     *
     * @return \DateTime
     */
    protected function criarDataAtualizacao()
    {
        return new \DateTime('2015-12-10 00:00:00');
    }
}
