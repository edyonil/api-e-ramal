<?php
declare(strict_types=1);

namespace Test\ContatoModulo\Infraestrutura\Repositorio\Usuario;

use AppTest\ContatoModulo\Infraestrutura\Repositorio\AbstractRepositorioTest;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioAutenticacaoRepositorio;
use ContatoModulo\Modelo\Usuario;
use Doctrine\ORM\EntityManager;

class UsuarioAutenticacaoRepositorioTest extends AbstractRepositorioTest
{
    public function testObterUsuarioAPartirDoLoginESenha()
    {
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

        $repositorio = new UsuarioAutenticacaoRepositorio($this->container->get(EntityManager::class));
        $usuario = $repositorio->getUsuario($email, $senha);

        $this->assertEquals($usuario, $outputRepo);
    }
}
