<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Aplicacao\Contato;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoService;
use ContatoModulo\Aplicacao\Contato\ImportarContatosServico;
use ContatoModulo\Aplicacao\Excel\LeitorArquivoContatos;
use ContatoModulo\Modelo\Contato;
use ContatoModulo\Modelo\Usuario;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\UploadedFile;

/**
 * Class ImportarContatosServicoTest
 *
 * @package AppTest\ContatoModulo\Aplicacao\Contato
 * @group Importar
 */
class ImportarContatosServicoTest extends TestCase
{
    public function testImportarContatosDeUmUsuario()
    {
        $arquivo = new UploadedFile(
            __DIR__ . "/../../../../../public/importacao-e-ramal.xlsx",
            34756,
            0
        );

        $token = $this->getToken();

        $leitorDados = [
            [
                'nome' => 'Alex Gomes',
                'setor' => 'GETEC',
                'ramalOuTelefone' => '3411',
            ],
            [
                'nome' => 'Alex Gomes',
                'setor' => 'GETEC',
                'ramalOuTelefone' => '3411',
            ],
            [
                'nome' => 'Alex Gomes',
                'setor' => 'GETEC',
                'ramalOuTelefone' => '3411',
            ],
        ];

        $emDados = new Contato();
        $emDados->setNome($leitorDados[0]['nome'])
            ->setSetor($leitorDados[0]['setor'])
            ->setRamalOuTelefone($leitorDados[0]['ramalOuTelefone'])
            ->setUsuario($this->getUsuario());

        $leitor = $this->prophesize(LeitorArquivoContatos::class);
        $leitor->getConteudo((string)$arquivo->getStream())
            ->willReturn($leitorDados)
            ->shouldBeCalled();

        $em = $this->prophesize(EntityManager::class);
        $em->persist($emDados);

        $autenticacao = $this->prophesize(AutenticacaoService::class);
        $autenticacao->obterUsuarioAutenticado($token)
            ->willReturn($this->getUsuario())
            ->shouldBeCalled();

        $servico = new ImportarContatosServico($leitor->reveal(), $em->reveal(),
            $autenticacao->reveal());
        $resultado = $servico->importarContatos($arquivo, $token);

        $em->flush()->willReturn()->shouldBeCalled();

        $this->assertTrue($resultado);
    }

    /**
     * Obtém um usuário para teste
     *
     * @return Usuario
     */
    protected function getUsuario(): Usuario
    {
        $usuario = new Usuario();
        $usuario->setNome('Alex Gomes')
            ->setEmail('alexrsg@gmail.com')
            ->setPassword('xyz123')
            ->setAtivo(true)
            ->setPrimeiroAcesso(true)
            ->setCompartilharContatos(true);

        return $usuario;
    }

    /**
     * Obtém um token para teste
     *
     * @return string
     */
    protected function getToken(): string
    {
        return 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE0OTgxMzY2NTEsImV4cCI6MTQ5ODIyMzA1MSwibmJmIjoxNDk4MTM2NjUwLCJkYXRhIjp7ImlkIjozNCwiZW1haWwiOiJhbGV4cnNnQGdtYWlsLmNvbSJ9fQ.VrQfohHgqygBk6sj4GVEX49-4-089ZE85OFp95i7Tns';
    }
}
