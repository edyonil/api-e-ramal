<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 14/04/17
 * Time: 19:04
 */

namespace AppTest\ContatoModulo\Aplicacao\Contato;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoInterface;
use ContatoModulo\Aplicacao\Contato\ContatoService;
use ContatoModulo\Infraestrutura\Repositorio\RepositorioInterface;
use ContatoModulo\Modelo\Contato;
use ContatoModulo\Modelo\Usuario;
use PHPUnit\Framework\TestCase;

/**
 * Class ContatoServiceTest
 * @package AppTest\ContatoModulo
 * @group   ContatoModulo
 */
class ContatoServiceTest extends TestCase
{

    public function testCriacaoDeUmContato()
    {

        // Input do form
        $contato = [
            'nome'            => 'Edy',
            'setor'           => 'GETEC',
            'ramalOuTelefone' => '3411',
        ];

        // Retorno do serviço
        $contatoRetorno = [
            'id'              => null,
            'nome'            => 'Edy',
            'setor'           => 'GETEC',
            'ramalOuTelefone' => '3411',
            'createdAt'       => '2015-12-03 00:00:00',
            'updatedAt'       => '2015-12-03 00:00:00',
            'deletedAt'       => null,
            'usuario'         => [
                'id'                   => null,
                'nome'                 => 'Edy',
                'email'                => 'edy@edy.com',
                'ativo'                => true,
                'primeiroAcesso'       => false,
                'compartilharContatos' => true,
                'createdAt'            => '2015-12-03 00:00:00',
                'updatedAt'            => '2015-12-03 00:00:00',
                'deletedAt'            => null
            ]
        ];

        // Modelos para Mock
        $dataUsuario = $contatoRetorno['usuario'];

        $usuario = new Usuario();

        $usuario->setNome($dataUsuario['nome'])
            ->setEmail($dataUsuario['email'])
            ->setAtivo($dataUsuario['ativo'])
            ->setPrimeiroAcesso($dataUsuario['primeiroAcesso'])
            ->setCompartilharContatos($dataUsuario['compartilharContatos'])
            ->setCreatedAt($dataUsuario['createdAt'])
            ->setUpdatedAt($dataUsuario['updatedAt'])
            ->setDeletedAt($dataUsuario['deletedAt']);

        $modelo = new Contato();
        $modelo->setNome($contatoRetorno['nome'])
            ->setRamalOuTelefone($contatoRetorno['ramalOuTelefone'])
            ->setSetor($contatoRetorno['setor'])
            ->setUsuario($usuario);


        $modeloRetorno = clone $modelo;

        $modeloRetorno->setCreatedAt($contatoRetorno['createdAt'])
            ->setUpdatedAt($contatoRetorno['updatedAt'])
            ->setDeletedAt($contatoRetorno['deletedAt']);

        // Mock da classe que obtem o usuário autenticado e retorna uma
        // do tipo Usuario
        $autenticacao = $this->prophesize(AutenticacaoInterface::class);
        $autenticacao->obterUsuarioAutenticado()
            ->willReturn($usuario);

        // Mock do repositório
        $repository = $this->prophesize(RepositorioInterface::class);
        $repository->adicionar($modelo)
            ->willReturn($modeloRetorno);

        $contatoServico = new ContatoService(
            $repository->reveal(),
            $autenticacao->reveal()
        );

        $add = $contatoServico->adicionarContato($contato);

        $this->assertEquals($add, $contatoRetorno);

    }

    public function testEdicaoDeUmContato()
    {

        $id = 1;
        // Input do form
        $contato = [
            'nome'            => 'Edy',
            'setor'           => 'SUOPE',
            'ramalOuTelefone' => '3411',
        ];

        // Retorno do serviço
        $contatoRetorno = [
            'id'              => null,
            'nome'            => 'Edy',
            'setor'           => 'SUOPE',
            'ramalOuTelefone' => '3411',
            'createdAt'       => '2015-12-03 00:00:00',
            'updatedAt'       => '2015-12-10 00:00:00',
            'deletedAt'       => null,
            'usuario'         => [
                'id'                   => null,
                'nome'                 => 'Edy',
                'email'                => 'edy@edy.com',
                'ativo'                => true,
                'primeiroAcesso'       => false,
                'compartilharContatos' => true,
                'createdAt'            => '2015-12-03 00:00:00',
                'updatedAt'            => '2015-12-03 00:00:00',
                'deletedAt'            => null
            ]
        ];

        // Modelos para Mock
        $dataUsuario = $contatoRetorno['usuario'];

        $usuario = new Usuario();

        $usuario->setNome($dataUsuario['nome'])
            ->setEmail($dataUsuario['email'])
            ->setAtivo($dataUsuario['ativo'])
            ->setPrimeiroAcesso($dataUsuario['primeiroAcesso'])
            ->setCompartilharContatos($dataUsuario['compartilharContatos'])
            ->setCreatedAt($dataUsuario['createdAt'])
            ->setUpdatedAt($dataUsuario['updatedAt'])
            ->setDeletedAt($dataUsuario['deletedAt']);

        //Para o repositorio
        $modelo = new Contato();
        $modelo->setNome($contatoRetorno['nome'])
            ->setRamalOuTelefone($contatoRetorno['ramalOuTelefone'])
            ->setUsuario($usuario)
            ->setSetor('GETEC')
            ->setCreatedAt($contatoRetorno['createdAt'])
            ->setUpdatedAt($contatoRetorno['createdAt'])
            ->setDeletedAt($contatoRetorno['deletedAt']);

        // Clone para o retorno do editar
        $modeloRetornoEditar = clone $modelo;
        $modeloRetornoEditar->setCreatedAt($contatoRetorno['createdAt'])
            ->setSetor($contatoRetorno['setor'])
            ->setUpdatedAt($contatoRetorno['updatedAt'])
            ->setDeletedAt($contatoRetorno['deletedAt']);

        // Mock da classe que obtem o usuário autenticado e retorna uma
        // do tipo Usuario
        $autenticacao = $this->prophesize(AutenticacaoInterface::class);
        $autenticacao->obterUsuarioAutenticado()
            ->willReturn($usuario);

        // Mock do repositório
        $repository = $this->prophesize(RepositorioInterface::class);

        $repository->encontrar($id)->willReturn($modelo);
        $repository->atualizar($modelo)->willReturn($modeloRetornoEditar);

        $contatoServico = new ContatoService(
            $repository->reveal(),
            $autenticacao->reveal()
        );


        $add = $contatoServico->editarContato($id, $contato);

        $this->assertEquals($add, $contatoRetorno);

    }

    public function testLocalizandoUmContato()
    {
        $id = 1;

        // Retorno do serviço
        $contatoRetorno = [
            'id'              => null,
            'nome'            => 'Edy',
            'setor'           => 'SUOPE',
            'ramalOuTelefone' => '3411',
            'createdAt'       => '2015-12-03 00:00:00',
            'updatedAt'       => '2015-12-10 00:00:00',
            'deletedAt'       => null,
            'usuario'         => [
                'id'                   => null,
                'nome'                 => 'Edy',
                'email'                => 'edy@edy.com',
                'ativo'                => true,
                'primeiroAcesso'       => false,
                'compartilharContatos' => true,
                'createdAt'            => '2015-12-03 00:00:00',
                'updatedAt'            => '2015-12-03 00:00:00',
                'deletedAt'            => null
            ]
        ];

        // Modelos para Mock
        $dataUsuario = $contatoRetorno['usuario'];

        $usuario = new Usuario();

        $usuario->setNome($dataUsuario['nome'])
            ->setEmail($dataUsuario['email'])
            ->setAtivo($dataUsuario['ativo'])
            ->setPrimeiroAcesso($dataUsuario['primeiroAcesso'])
            ->setCompartilharContatos($dataUsuario['compartilharContatos'])
            ->setCreatedAt($dataUsuario['createdAt'])
            ->setUpdatedAt($dataUsuario['updatedAt'])
            ->setDeletedAt($dataUsuario['deletedAt']);

        //Para o repositorio
        $modelo = new Contato();
        $modelo->setNome($contatoRetorno['nome'])
            ->setRamalOuTelefone($contatoRetorno['ramalOuTelefone'])
            ->setSetor($contatoRetorno['setor'])
            ->setUsuario($usuario)
            ->setCreatedAt($contatoRetorno['createdAt'])
            ->setUpdatedAt($contatoRetorno['updatedAt'])
            ->setDeletedAt($contatoRetorno['deletedAt']);

        // Mock da classe que obtem o usuário autenticado e retorna uma
        // do tipo Usuario
        $autenticacao = $this->prophesize(AutenticacaoInterface::class);

        // Mock do repositório
        $repository = $this->prophesize(RepositorioInterface::class);

        $repository->encontrar($id)->willReturn($modelo);

        $contatoServico = new ContatoService(
            $repository->reveal(),
            $autenticacao->reveal()
        );

        $localizado = $contatoServico->localizarContato($id);

        $this->assertEquals($localizado, $contatoRetorno);
    }

    public function testListarContatosComPaginacao()
    {
        // Retorno do serviço
        $contatoRetorno = [
            [
                'id'              => null,
                'nome'            => 'Edy',
                'setor'           => 'SUOPE',
                'ramalOuTelefone' => '3411',
                'createdAt'       => '2015-12-03 00:00:00',
                'updatedAt'       => '2015-12-10 00:00:00',
                'deletedAt'       => null,
                'usuario'         => [
                    'id'                   => null,
                    'nome'                 => 'Edy',
                    'email'                => 'edy@edy.com',
                    'ativo'                => true,
                    'primeiroAcesso'       => false,
                    'compartilharContatos' => true,
                    'createdAt'            => '2015-12-03 00:00:00',
                    'updatedAt'            => '2015-12-03 00:00:00',
                    'deletedAt'            => null
                ]
            ],
            [
                'id'              => null,
                'nome'            => 'Edy',
                'setor'           => 'SUOPE',
                'ramalOuTelefone' => '3411',
                'createdAt'       => '2015-12-03 00:00:00',
                'updatedAt'       => '2015-12-10 00:00:00',
                'deletedAt'       => null,
                'usuario'         => [
                    'id'                   => null,
                    'nome'                 => 'Edy',
                    'email'                => 'edy@edy.com',
                    'ativo'                => true,
                    'primeiroAcesso'       => false,
                    'compartilharContatos' => true,
                    'createdAt'            => '2015-12-03 00:00:00',
                    'updatedAt'            => '2015-12-03 00:00:00',
                    'deletedAt'            => null
                ]
            ],
            [
                'id'              => null,
                'nome'            => 'Edy',
                'setor'           => 'SUOPE',
                'ramalOuTelefone' => '3411',
                'createdAt'       => '2015-12-03 00:00:00',
                'updatedAt'       => '2015-12-10 00:00:00',
                'deletedAt'       => null,
                'usuario'         => [
                    'id'                   => null,
                    'nome'                 => 'Edy',
                    'email'                => 'edy@edy.com',
                    'ativo'                => true,
                    'primeiroAcesso'       => false,
                    'compartilharContatos' => true,
                    'createdAt'            => '2015-12-03 00:00:00',
                    'updatedAt'            => '2015-12-03 00:00:00',
                    'deletedAt'            => null
                ]
            ]
        ];

        // Modelos para Mock
        $dataUsuario = $contatoRetorno[0]['usuario'];

        $usuario = new Usuario();

        $usuario->setNome($dataUsuario['nome'])
            ->setEmail($dataUsuario['email'])
            ->setAtivo($dataUsuario['ativo'])
            ->setPrimeiroAcesso($dataUsuario['primeiroAcesso'])
            ->setCompartilharContatos($dataUsuario['compartilharContatos'])
            ->setCreatedAt($dataUsuario['createdAt'])
            ->setUpdatedAt($dataUsuario['updatedAt'])
            ->setDeletedAt($dataUsuario['deletedAt']);

        //Para o repositorio
        $modelo = new Contato();
        $modelo->setNome($contatoRetorno[0]['nome'])
            ->setRamalOuTelefone($contatoRetorno[0]['ramalOuTelefone'])
            ->setSetor($contatoRetorno[0]['setor'])
            ->setUsuario($usuario)
            ->setCreatedAt($contatoRetorno[0]['createdAt'])
            ->setUpdatedAt($contatoRetorno[0]['updatedAt'])
            ->setDeletedAt($contatoRetorno[0]['deletedAt']);

        $data = [
            clone $modelo,
            clone $modelo,
            clone $modelo
        ];

        $input = [
            'page' => 1,
            'limit' => 2,
            'usuario' => null
        ];

        // Mock da classe que obtem o usuário autenticado e retorna uma
        // do tipo Usuario
        $autenticacao = $this->prophesize(AutenticacaoInterface::class);
        $autenticacao->obterUsuarioAutenticado()
            ->willReturn($usuario);

        // Mock do repositório
        $repository = $this->prophesize(RepositorioInterface::class);

        $repository->listar($input)->willReturn($data);

        $contatoServico = new ContatoService(
            $repository->reveal(),
            $autenticacao->reveal()
        );

        $localizado = $contatoServico->listarContato($input);

        $this->assertEquals($localizado['itens'], $contatoRetorno);
        $this->assertCount(3, $localizado['total']);
    }

    public function testExcluindoUmContato()
    {
        $id = 1;

        // Retorno do serviço
        $contatoRetorno = [
            'id'              => null,
            'nome'            => 'Edy',
            'setor'           => 'SUOPE',
            'ramalOuTelefone' => '3411',
            'createdAt'       => '2015-12-03 00:00:00',
            'updatedAt'       => '2015-12-10 00:00:00',
            'deletedAt'       => null,
            'usuario'         => [
                'id'                   => null,
                'nome'                 => 'Edy',
                'email'                => 'edy@edy.com',
                'ativo'                => true,
                'primeiroAcesso'       => false,
                'compartilharContatos' => true,
                'createdAt'            => '2015-12-03 00:00:00',
                'updatedAt'            => '2015-12-03 00:00:00',
                'deletedAt'            => null
            ]
        ];

        // Modelos para Mock
        $dataUsuario = $contatoRetorno['usuario'];

        $usuario = new Usuario();

        $usuario->setNome($dataUsuario['nome'])
            ->setEmail($dataUsuario['email'])
            ->setAtivo($dataUsuario['ativo'])
            ->setPrimeiroAcesso($dataUsuario['primeiroAcesso'])
            ->setCompartilharContatos($dataUsuario['compartilharContatos'])
            ->setCreatedAt($dataUsuario['createdAt'])
            ->setUpdatedAt($dataUsuario['updatedAt'])
            ->setDeletedAt($dataUsuario['deletedAt']);

        //Para o repositorio
        $modelo = new Contato();
        $modelo->setNome($contatoRetorno['nome'])
            ->setRamalOuTelefone($contatoRetorno['ramalOuTelefone'])
            ->setSetor($contatoRetorno['setor'])
            ->setUsuario($usuario)
            ->setCreatedAt($contatoRetorno['createdAt'])
            ->setUpdatedAt($contatoRetorno['updatedAt'])
            ->setDeletedAt($contatoRetorno['deletedAt']);

        // Mock da classe que obtem o usuário autenticado e retorna uma
        // do tipo Usuario
        $autenticacao = $this->prophesize(AutenticacaoInterface::class);

        // Mock do repositório
        $repository = $this->prophesize(RepositorioInterface::class);

        $repository->encontrar($id)->willReturn($modelo)->shouldBeCalled();

        $repository->excluir($modelo)->willReturn(true)->shouldBeCalled();

        $contatoServico = new ContatoService(
            $repository->reveal(),
            $autenticacao->reveal()
        );

        $this->assertTrue($contatoServico->excluirContato($id));
    }
}
