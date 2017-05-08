<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 02/05/17
 * Time: 13:44
 */

namespace ContatoModulo\Aplicacao\Excecao;

use Throwable;

/**
 * Class UsuarioException
 *
 * @package ContatoModulo\Aplicacao\Excecao
 */
class UsuarioException extends \Exception
{
    public function __construct(
        $message = "Usuário não encontrado",
        $code = 0,
        Throwable $previous = null
    ) {

        parent::__construct($message, $code, $previous);
    }
}
