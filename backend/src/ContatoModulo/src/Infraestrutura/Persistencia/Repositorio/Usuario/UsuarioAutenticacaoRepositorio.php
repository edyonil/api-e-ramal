<?php
declare(strict_types=1);

namespace ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario;

use ContatoModulo\Modelo\Usuario;
use Doctrine\ORM\EntityManager;
use ContatoModulo\Aplicacao\Excecao\UsuarioException;

/**
 * Class UsuarioAutenticacaoRepositorio
 *
 * @package ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario
 */
class UsuarioAutenticacaoRepositorio
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * UsuarioAutenticacaoRepositorio constructor.
     *
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Obtém o usuário a partir do login e senha
     *
     * @param $email
     * @param $password
     * @return Usuario
     */
    public function getUsuario($email, $password): Usuario
    {
        $logado = $this->em->getRepository(Usuario::class)
                    ->findOneBy([
                            'email' => $email,
                            'password' => $password,
                        ]
                    );

        if (is_null($logado)) {
            throw new UsuarioException("Usuário não encontrado");

        }
    }
}
