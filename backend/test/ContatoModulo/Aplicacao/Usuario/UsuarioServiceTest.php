<?php
declare(strict_types=1);

use ContatoModulo\Infraestrutura\Persistencia\Repositorio\RepositorioInterface;
use ContatoModulo\Modelo\Usuario;
use PHPUnit\Framework\TestCase;
use ContatoModulo\Aplicacao\Usuario\UsuarioService;

/**
 * Class UsuarioServiceTest
 *
 * @package AppTest\ContatoModulo\Aplicacao\Contato
 * @group ContatoModulo
 */
class UsuarioServiceTest extends TestCase
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
            'createdAt' => '2017-05-03 00:00:00',
            'updatedAt' => '2017-05-03 00:00:00',
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
        $outputRepo->setCreatedAt('2017-05-03 00:00:00')
            ->setUpdatedAt('2017-05-03 00:00:00');

        $repositorio = $this->prophesize(RepositorioInterface::class);
        $repositorio->adicionar($inputRepo)->willReturn($outputRepo);

        $usuarioServico = new UsuarioService($repositorio->reveal());

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
            'createdAt' => '2017-05-03 00:00:00',
            'updatedAt' => '2017-05-03 01:00:00',
            'deletedAt' => null,
        ];

        $inputRepo = new Usuario();
        $inputRepo->setAtivo(true)
            ->setCompartilharContatos(false)
            ->setCreatedAt('2017-05-03 00:00:00')
            ->setDeletedAt(null)
            ->setEmail($input['email'])
            ->setNome($input['nome'])
            ->setPassword($input['password'])
            ->setPrimeiroAcesso(false)
            ->setUpdatedAt('2017-05-03 01:00:00');

        $outputRepo = clone $inputRepo;
        $outputRepoEditar = clone $outputRepo;

        $repositorio = $this->prophesize(RepositorioInterface::class);

        $repositorio->encontrar($id)->willReturn($outputRepo);
        $repositorio->atualizar($inputRepo)->willReturn($outputRepoEditar);

        $usuarioServico = new UsuarioService($repositorio->reveal());

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
            'createdAt' => '2017-05-03 00:00:00',
            'updatedAt' => '2017-05-03 00:00:00',
            'deletedAt' => null,
        ];

        $outputRepo = new Usuario();

        $outputRepo->setNome($output['nome'])
            ->setEmail($output['email'])
            ->setAtivo($output['ativo'])
            ->setPrimeiroAcesso($output['primeiroAcesso'])
            ->setCompartilharContatos($output['compartilharContatos'])
            ->setCreatedAt($output['createdAt'])
            ->setUpdatedAt($output['updatedAt'])
            ->setDeletedAt($output['deletedAt']);

        // Mock do repositório
        $repository = $this->prophesize(RepositorioInterface::class);

        $repository->encontrar($id)->willReturn($outputRepo);

        $usuarioService = new UsuarioService($repository->reveal());

        $resultado = $usuarioService->localizarUsuario($id);

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
                'createdAt' => '2017-05-03 00:00:00',
                'updatedAt' => '2017-05-03 00:00:00',
                'deletedAt' => null,
            ],
            [
                'id' => null,
                'nome' => 'Alex Gomes',
                'email' => 'alexrsg@gmail.com',
                'ativo' => true,
                'primeiroAcesso' => true,
                'compartilharContatos' => false,
                'createdAt' => '2017-05-03 00:00:00',
                'updatedAt' => '2017-05-03 00:00:00',
                'deletedAt' => null,
            ],
            [
                'id' => null,
                'nome' => 'Alex Gomes',
                'email' => 'alexrsg@gmail.com',
                'ativo' => true,
                'primeiroAcesso' => true,
                'compartilharContatos' => false,
                'createdAt' => '2017-05-03 00:00:00',
                'updatedAt' => '2017-05-03 00:00:00',
                'deletedAt' => null,
            ]
        ];

        $usuario = new Usuario();

        $usuario->setNome($output[0]['nome'])
            ->setEmail($output[0]['email'])
            ->setAtivo($output[0]['ativo'])
            ->setPrimeiroAcesso($output[0]['primeiroAcesso'])
            ->setCompartilharContatos($output[0]['compartilharContatos'])
            ->setCreatedAt($output[0]['createdAt'])
            ->setUpdatedAt($output[0]['updatedAt'])
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

        $usuarioService = new UsuarioService($repository->reveal());

        $resultado = $usuarioService->listarUsuario($input);

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
            'createdAt' => '2017-05-03 00:00:00',
            'updatedAt' => '2017-05-03 00:00:00',
            'deletedAt' => null,
        ];

        $outputRepo = new Usuario();

        $outputRepo->setNome($output['nome'])
            ->setEmail($output['email'])
            ->setAtivo($output['ativo'])
            ->setPrimeiroAcesso($output['primeiroAcesso'])
            ->setCompartilharContatos($output['compartilharContatos'])
            ->setCreatedAt($output['createdAt'])
            ->setUpdatedAt($output['updatedAt'])
            ->setDeletedAt($output['deletedAt']);

        // Mock do repositório
        $repository = $this->prophesize(RepositorioInterface::class);

        $repository->encontrar($id)->willReturn($outputRepo)->shouldBeCalled();

        $repository->excluir($outputRepo)->willReturn(true)->shouldBeCalled();

        $usuarioServico = new UsuarioService($repository->reveal());

        $this->assertTrue($usuarioServico->excluirUsuario($id));
    }
}
