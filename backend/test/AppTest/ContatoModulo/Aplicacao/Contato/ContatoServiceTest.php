<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 14/04/17
 * Time: 19:04
 */
namespace AppTest\ContatoModulo\Aplicacao\Contato;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoInterface;
use ContatoModulo\Aplicacao\Contato\ContatoService;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\RepositorioInterface;
use ContatoModulo\Modelo\Contato;
use ContatoModulo\Modelo\Usuario;
use PHPUnit\Framework\TestCase;

/**
 * Class ContatoServiceTest
 *
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
            'token'           => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9
    .eyJpYXQiOjE0NzA2MDczMDAsImlzcyI6ImRvdWdsYXNwYXNxdWEuY29tIiwiZXhwIjox
    NDcwNjEwOTAwLCJuYmYiOjE0NzA2MDcyOTksImRhdGEiOnsiaWQiOjEsIm5hbWUiOiJEb3
    VnbGFzIFBhc3F1YSJ9fQ.WuT3TRLqUkzOgDdEr1YiQdXhz0OvwMDTzYpeKDDFDAY'
        ];

        // Retorno do serviço
        $contatoRetorno = [
            'id'              => null,
            'nome'            => 'Edy',
            'setor'           => 'GETEC',
            'ramalOuTelefone' => '3411',
            'createdAt'       => '03/12/2015 00:00:00',
            'updatedAt'       => '03/12/2015 00:00:00',
            'deletedAt'       => null,
            'usuario'         => [
                'id'                   => null,
                'nome'                 => 'Edy',
                'email'                => 'edy@edy.com',
                'ativo'                => true,
                'primeiroAcesso'       => false,
                'compartilharContatos' => true,
                'createdAt'            => '03/12/2015 00:00:00',
                'updatedAt'            => '03/12/2015 00:00:00',
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
            ->setCreatedAt($this->criarDataCadastro())
            ->setUpdatedAt($this->criarDataCadastro())
            ->setDeletedAt($dataUsuario['deletedAt']);

        $modelo = new Contato();
        $modelo->setNome($contatoRetorno['nome'])
            ->setRamalOuTelefone($contatoRetorno['ramalOuTelefone'])
            ->setSetor($contatoRetorno['setor'])
            ->setUsuario($usuario);

        $modeloRetorno = clone $modelo;

        $modeloRetorno->setCreatedAt($this->criarDataCadastro())
            ->setUpdatedAt($this->criarDataCadastro())
            ->setDeletedAt($contatoRetorno['deletedAt']);

        // Mock da classe que obtem o usuário autenticado e retorna uma
        // do tipo Usuario
        $autenticacao = $this->prophesize(AutenticacaoInterface::class);
        $autenticacao->obterUsuarioAutenticado($contato['token'])
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
            'token'           => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9
    .eyJpYXQiOjE0NzA2MDczMDAsImlzcyI6ImRvdWdsYXNwYXNxdWEuY29tIiwiZXhwIjox
    NDcwNjEwOTAwLCJuYmYiOjE0NzA2MDcyOTksImRhdGEiOnsiaWQiOjEsIm5hbWUiOiJEb3
    VnbGFzIFBhc3F1YSJ9fQ.WuT3TRLqUkzOgDdEr1YiQdXhz0OvwMDTzYpeKDDFDAY'
        ];

        // Retorno do serviço
        $contatoRetorno = [
            'id'              => null,
            'nome'            => 'Edy',
            'setor'           => 'SUOPE',
            'ramalOuTelefone' => '3411',
            'createdAt'       => '03/12/2015 00:00:00',
            'updatedAt'       => '10/12/2015 00:00:00',
            'deletedAt'       => null,
            'usuario'         => [
                'id'                   => null,
                'nome'                 => 'Edy',
                'email'                => 'edy@edy.com',
                'ativo'                => true,
                'primeiroAcesso'       => false,
                'compartilharContatos' => true,
                'createdAt'            => '03/12/2015 00:00:00',
                'updatedAt'            => '03/12/2015 00:00:00',
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
            ->setCreatedAt($this->criarDataCadastro())
            ->setUpdatedAt($this->criarDataCadastro())
            ->setDeletedAt($dataUsuario['deletedAt']);

        // Para o repositorio
        $modelo = new Contato();
        $modelo->setNome($contatoRetorno['nome'])
            ->setRamalOuTelefone($contatoRetorno['ramalOuTelefone'])
            ->setUsuario($usuario)
            ->setSetor('GETEC')
            ->setCreatedAt($this->criarDataCadastro())
            ->setUpdatedAt($this->criarDataAtualizacao())
            ->setDeletedAt($contatoRetorno['deletedAt']);

        // Clone para o retorno do editar
        $modeloRetornoEditar = clone $modelo;
        $modeloRetornoEditar->setCreatedAt($this->criarDataCadastro())
            ->setSetor($contatoRetorno['setor'])
            ->setUpdatedAt($this->criarDataAtualizacao())
            ->setDeletedAt($contatoRetorno['deletedAt']);

        // Mock da classe que obtem o usuário autenticado e retorna uma
        // do tipo Usuario
        $autenticacao = $this->prophesize(AutenticacaoInterface::class);
        $autenticacao->obterUsuarioAutenticado($contato['token'])
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

        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9
.eyJpYXQiOjE0NzA2MDczMDAsImlzcyI6ImRvdWdsYXNwYXNxdWEuY29tIiwiZXhwIjox
NDcwNjEwOTAwLCJuYmYiOjE0NzA2MDcyOTksImRhdGEiOnsiaWQiOjEsIm5hbWUiOiJEb3
VnbGFzIFBhc3F1YSJ9fQ.WuT3TRLqUkzOgDdEr1YiQdXhz0OvwMDTzYpeKDDFDAY';

        // Retorno do serviço
        $contatoRetorno = [
            'id'              => null,
            'nome'            => 'Edy',
            'setor'           => 'SUOPE',
            'ramalOuTelefone' => '3411',
            'createdAt'       => '03/12/2015 00:00:00',
            'updatedAt'       => '10/12/2015 00:00:00',
            'deletedAt'       => null,
            'usuario'         => [
                'id'                   => null,
                'nome'                 => 'Edy',
                'email'                => 'edy@edy.com',
                'ativo'                => true,
                'primeiroAcesso'       => false,
                'compartilharContatos' => true,
                'createdAt'            => '03/12/2015 00:00:00',
                'updatedAt'            => '03/12/2015 00:00:00',
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
            ->setCreatedAt($this->criarDataCadastro())
            ->setUpdatedAt($this->criarDataCadastro())
            ->setDeletedAt($dataUsuario['deletedAt']);

        // Para o repositorio
        $modelo = new Contato();
        $modelo->setNome($contatoRetorno['nome'])
            ->setRamalOuTelefone($contatoRetorno['ramalOuTelefone'])
            ->setSetor($contatoRetorno['setor'])
            ->setUsuario($usuario)
            ->setCreatedAt($this->criarDataCadastro())
            ->setUpdatedAt($this->criarDataAtualizacao())
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
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9
.eyJpYXQiOjE0NzA2MDczMDAsImlzcyI6ImRvdWdsYXNwYXNxdWEuY29tIiwiZXhwIjox
NDcwNjEwOTAwLCJuYmYiOjE0NzA2MDcyOTksImRhdGEiOnsiaWQiOjEsIm5hbWUiOiJEb3
VnbGFzIFBhc3F1YSJ9fQ.WuT3TRLqUkzOgDdEr1YiQdXhz0OvwMDTzYpeKDDFDAY';
        // Retorno do serviço
        $contatoRetorno = [
            [
                'id'              => null,
                'nome'            => 'Edy',
                'setor'           => 'SUOPE',
                'ramalOuTelefone' => '3411',
                'ordem'           => 1,
                'createdAt'       => '03/12/2015 00:00:00',
                'updatedAt'       => '10/12/2015 00:00:00',
                'deletedAt'       => null,
                'usuario'         => [
                    'id'                   => null,
                    'nome'                 => 'Edy',
                    'email'                => 'edy@edy.com',
                    'ativo'                => true,
                    'primeiroAcesso'       => false,
                    'compartilharContatos' => true,
                    'createdAt'            => '03/12/2015 00:00:00',
                    'updatedAt'            => '03/12/2015 00:00:00',
                    'deletedAt'            => null
                ]
            ],
            [
                'id'              => null,
                'nome'            => 'Edy',
                'setor'           => 'SUOPE',
                'ramalOuTelefone' => '3411',
                'ordem'           => 2,
                'createdAt'       => '03/12/2015 00:00:00',
                'updatedAt'       => '10/12/2015 00:00:00',
                'deletedAt'       => null,
                'usuario'         => [
                    'id'                   => null,
                    'nome'                 => 'Edy',
                    'email'                => 'edy@edy.com',
                    'ativo'                => true,
                    'primeiroAcesso'       => false,
                    'compartilharContatos' => true,
                    'createdAt'            => '03/12/2015 00:00:00',
                    'updatedAt'            => '03/12/2015 00:00:00',
                    'deletedAt'            => null
                ]
            ],
            [
                'id'              => null,
                'nome'            => 'Edy',
                'setor'           => 'SUOPE',
                'ramalOuTelefone' => '3411',
                'ordem'           => 3,
                'createdAt'       => '03/12/2015 00:00:00',
                'updatedAt'       => '10/12/2015 00:00:00',
                'deletedAt'       => null,
                'usuario'         => [
                    'id'                   => null,
                    'nome'                 => 'Edy',
                    'email'                => 'edy@edy.com',
                    'ativo'                => true,
                    'primeiroAcesso'       => false,
                    'compartilharContatos' => true,
                    'createdAt'            => '03/12/2015 00:00:00',
                    'updatedAt'            => '03/12/2015 00:00:00',
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
            ->setCreatedAt($this->criarDataCadastro())
            ->setUpdatedAt($this->criarDataCadastro())
            ->setDeletedAt($dataUsuario['deletedAt']);

        // Para o repositorio
        $modelo = new Contato();
        $modelo->setNome($contatoRetorno[0]['nome'])
            ->setRamalOuTelefone($contatoRetorno[0]['ramalOuTelefone'])
            ->setSetor($contatoRetorno[0]['setor'])
            ->setUsuario($usuario)
            ->setCreatedAt($this->criarDataCadastro())
            ->setUpdatedAt($this->criarDataAtualizacao())
            ->setDeletedAt($contatoRetorno[0]['deletedAt']);

        $data = [
            clone $modelo,
            clone $modelo,
            clone $modelo
        ];

        $input = [
            'page' => 1,
            'limit' => 2,
            'usuario' => null,
            'token' => $token
        ];

        // Mock da classe que obtem o usuário autenticado e retorna uma
        // do tipo Usuario
        $autenticacao = $this->prophesize(AutenticacaoInterface::class);
        $autenticacao->obterUsuarioAutenticado($token)
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
        $this->assertCount(3, $localizado['itens']);
    }

    public function testListarContatosVazios()
    {
        $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9
.eyJpYXQiOjE0NzA2MDczMDAsImlzcyI6ImRvdWdsYXNwYXNxdWEuY29tIiwiZXhwIjox
NDcwNjEwOTAwLCJuYmYiOjE0NzA2MDcyOTksImRhdGEiOnsiaWQiOjEsIm5hbWUiOiJEb3
VnbGFzIFBhc3F1YSJ9fQ.WuT3TRLqUkzOgDdEr1YiQdXhz0OvwMDTzYpeKDDFDAY';

        $usuarioC         = [
            'id'                   => null,
            'nome'                 => 'Edy',
            'email'                => 'edy@edy.com',
            'ativo'                => true,
            'primeiroAcesso'       => false,
            'compartilharContatos' => true,
            'createdAt'            => '03/12/2015 00:00:00',
            'updatedAt'            => '03/12/2015 00:00:00',
            'deletedAt'            => null
        ];

        $usuario = new Usuario();

        $usuario->setNome($usuarioC['nome'])
            ->setEmail($usuarioC['email'])
            ->setAtivo($usuarioC['ativo'])
            ->setPrimeiroAcesso($usuarioC['primeiroAcesso'])
            ->setCompartilharContatos($usuarioC['compartilharContatos'])
            ->setCreatedAt($this->criarDataCadastro())
            ->setUpdatedAt($this->criarDataCadastro())
            ->setDeletedAt($usuarioC['deletedAt']);

        // Para o repositorio
        $modelo = new Contato();

        $input = [
            'page' => 1,
            'limit' => 2,
            'usuario' => null,
            'token' => $token
        ];

        // Mock da classe que obtem o usuário autenticado e retorna uma
        // do tipo Usuario
        $autenticacao = $this->prophesize(AutenticacaoInterface::class);
        $autenticacao->obterUsuarioAutenticado($token)
            ->willReturn($usuario);

        // Mock do repositório
        $repository = $this->prophesize(RepositorioInterface::class);

        $repository->listar($input)->willReturn([]);

        $contatoServico = new ContatoService(
            $repository->reveal(),
            $autenticacao->reveal()
        );

        $localizado = $contatoServico->listarContato($input);

        $this->assertEquals($localizado['itens'], []);
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
            'createdAt'       => '03/12/2015 00:00:00',
            'updatedAt'       => '10/12/2015 00:00:00',
            'deletedAt'       => null,
            'usuario'         => [
                'id'                   => null,
                'nome'                 => 'Edy',
                'email'                => 'edy@edy.com',
                'ativo'                => true,
                'primeiroAcesso'       => false,
                'compartilharContatos' => true,
                'createdAt'            => '03/12/2015 00:00:00',
                'updatedAt'            => '03/12/2015 00:00:00',
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
            ->setCreatedAt($this->criarDataCadastro())
            ->setUpdatedAt($this->criarDataCadastro())
            ->setDeletedAt($dataUsuario['deletedAt']);

        // Para o repositorio
        $modelo = new Contato();
        $modelo->setNome($contatoRetorno['nome'])
            ->setRamalOuTelefone($contatoRetorno['ramalOuTelefone'])
            ->setSetor($contatoRetorno['setor'])
            ->setUsuario($usuario)
            ->setCreatedAt($this->criarDataCadastro())
            ->setUpdatedAt($this->criarDataAtualizacao())
            ->setDeletedAt($contatoRetorno['deletedAt']);

        // Mock da classe que obtem o usuário autenticado e retorna uma
        // do tipo Usuario
        $autenticacao = $this->prophesize(AutenticacaoInterface::class);
        $autenticacao->obterUsuarioAutenticado($token)
            ->willReturn($usuario);

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
