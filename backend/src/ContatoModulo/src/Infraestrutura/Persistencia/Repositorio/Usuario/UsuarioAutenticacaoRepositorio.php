<?php
declare(strict_types=1);

namespace ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario;

use ContatoModulo\Modelo\Usuario;

class UsuarioAutenticacaoRepositorio extends UsuarioRepositorio
{
    public function getUsuario($email, $password): Usuario
    {
        $usuario = $this->listar([
            'email' => $email,
            'password' => $password,
        ]);

        if ($usuario === null) {
            throw new \Exception("Usuário/senha inválidos.", 1);
        }

        return $usuario[0];
    }
}
