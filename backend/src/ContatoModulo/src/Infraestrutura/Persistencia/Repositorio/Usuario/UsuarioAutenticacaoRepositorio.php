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
class UsuarioAutenticacaoRepositorio extends UsuarioRepositorio
{
    /**
     * Obtém o usuário a partir do login e senha
     *
     * @param $email
     * @param $password
     * @return Usuario
     * @throws UsuarioException
     */
    public function getUsuario($email, $password): Usuario
    {
        $logado = $this->entityManager->getRepository(Usuario::class)
                    ->findOneBy([
                            'email' => $email,
                            'password' => $password,
                            'deletedAt' => null,
                        ]
                    );

        if (is_null($logado)) {
            throw new UsuarioException("Usuário não encontrado");

        }

        return $logado;
    }
}
