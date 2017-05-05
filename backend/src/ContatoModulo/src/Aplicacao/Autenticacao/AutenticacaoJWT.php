<?php
declare(strict_types=1);

namespace ContatoModulo\Aplicacao\Autenticacao;

use \ContatoModulo\Modelo\Usuario;
use \Firebase\JWT\JWT;

/**
 * Class AutenticacaoJWT
 *
 * @package ContatoModulo\Aplicacao\Autenticacao
 */
class AutenticacaoJWT implements TipoAutenticacaoInterface
{
    private $chave = '7Fsxc2A865V6'; // chave

    private $expiracao = 3600;

    private $criptografia = 'HS256';

    public function getToken(Usuario $usuario): array
    {
        $tempo = time();
        $expire = $tempo + $this->getExpiracao(); // tempo de expiracao do token

        $tokenParam = [
            'iat' => $tempo,            // timestamp de geracao do token
            'exp' => $expire,              // expiracao do token
            'nbf' => $tempo - 1,        // token nao eh valido Antes de
            'data' => [
                'id' => $usuario->getId(),
                'email' => $usuario->getEmail()
            ], // Dados do usuario logado
        ];

        return ['token' => JWT::encode($tokenParam, $this->getChave())];
    }

    public function extrairDados(string $token): \stdClass
    {
        return JWT::decode($token, $this->getChave(), [$this->getCriptografia()]);
    }

    public function setChave(string $chave): AutenticacaoJWT
    {
        $this->chave = $chave;

        return $this;
    }

    public function getChave(): string
    {
        return $this->chave;
    }

    public function setExpiracao(int $expiracao): AutenticacaoJWT
    {
        $this->expiracao = $expiracao;

        return $this;
    }

    public function getExpiracao()
    {
        return $this->expiracao;
    }

    public function setCriptografia(string $criptografia)
    {
        $this->criptografia = $criptografia;

        return $this;
    }

    public function getCriptografia()
    {
        return $this->criptografia;
    }
}
