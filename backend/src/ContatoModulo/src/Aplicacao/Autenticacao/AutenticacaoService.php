<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 02/05/17
 * Time: 12:48
 */

namespace ContatoModulo\Aplicacao\Autenticacao;

use ContatoModulo\Aplicacao\Excecao\UsuarioException;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario\UsuarioAutenticacaoRepositorio;
use ContatoModulo\Modelo\Usuario;

class AutenticacaoService implements AutenticacaoInterface
{

    /**
     * @var TipoAutenticacaoInterface
     */
    private $tipoAutenticacao;
    /**
     * @var UsuarioAutenticacaoRepositorio
     */
    private $usuarioAutenticacaoRepositorio;

    public function __construct(TipoAutenticacaoInterface $tipoAutenticacao
    , UsuarioAutenticacaoRepositorio $usuarioAutenticacaoRepositorio)
    {
        $this->tipoAutenticacao = $tipoAutenticacao;
        $this->usuarioAutenticacaoRepositorio = $usuarioAutenticacaoRepositorio;
    }

    public function obterUsuarioAutenticado(string $token): Usuario
    {
        $dadosUsuario = $this->tipoAutenticacao->extrairDados($token);

        return $this->usuarioAutenticacaoRepositorio
        ->encontrar($dadosUsuario->data->id);
    }

    public function login(string $email, string $password): array
    {

        $usuario = $this->usuarioAutenticacaoRepositorio
            ->getUsuario($email, $password);

        if (is_null($usuario)) {
            throw new UsuarioException('Usuário ou senha inválido');
        };

        if (!$usuario->ativo()) {
            throw new UsuarioException(
                'Usuário inativo. Entre em contato com administrador'
            );
        };

        $token = $this->tipoAutenticacao->getToken($usuario);

        return [
            'token' => $token['token']
        ];
    }
}
