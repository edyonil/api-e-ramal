<?php
declare(strict_types=1);

namespace ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario;

use ContatoModulo\Modelo\Usuario;
use Doctrine\ORM\EntityManager;

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
        return $this->em->findBy([
            'email' => $email,
            'password' => $password,
        ]);
    }
}
