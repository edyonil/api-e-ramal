<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 16/04/17
 * Time: 21:50
 */

namespace ContatoModulo\Aplicacao\Autenticacao;

use ContatoModulo\Modelo\Usuario;

interface AutenticacaoInterface
{
    public function obterUsuarioAutenticado(): Usuario;
}
