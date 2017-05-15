<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Infraestrutura\Repositorio\Usuario;

use AppTest\ContatoModulo\Infraestrutura\Repositorio\AbstractRepositorio;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioAutenticacaoRepositorio;
use ContatoModulo\Modelo\Usuario;
use Doctrine\ORM\EntityManager;

class UsuarioAutenticacaoRepositorioTest extends AbstractRepositorio
{
    public function testObterUsuarioAPartirDoLoginESenha()
    {
        //$this->skippedTest();
        $email = 'alexrsg@gmail.com';
        $senha = 'xyz123';

        $outputRepo = new Usuario();
        $outputRepo->setAtivo(true)
            ->setCompartilharContatos(false)
            ->setCreatedAt('2017-05-03 00:00:00')
            ->setDeletedAt(null)
            ->setEmail($email)
            ->setNome('Alex Gomes')
            ->setPassword($senha)
            ->setPrimeiroAcesso(true)
            ->setUpdatedAt('2017-05-03 00:00:00');

        $em = self::obterContainer(EntityManager::class);
        $repositorio = new UsuarioAutenticacaoRepositorio($em);
        $usuario = $repositorio->getUsuario($email, $senha);

        $this->assertEquals($usuario, $outputRepo);
    }
}
