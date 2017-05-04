<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 02/05/17
 * Time: 12:55
 */

namespace ContatoModulo\Aplicacao\Autenticacao;

use ContatoModulo\Modelo\Usuario;

interface TipoAutenticacaoInterface
{
    public function getToken(Usuario $usuario) : array;

    public function extrairDados(string $token) : \stdClass;
}
