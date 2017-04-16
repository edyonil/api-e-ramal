<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 14/04/17
 * Time: 19:04
 */

namespace AppTest\ContatoModulo;

use ContatoModulo\Aplicacao\ContatoServico;
use ContatoModulo\Modelo\Contato;
use ContatoModulo\Infraestrutura\Repositorio\RepositorioInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class ContatoServiceTest
 * @package AppTest\ContatoModulo
 * @group ContatoModulo
 */
class ContatoServiceTest extends TestCase
{

    public function testFunctionTestNamespace()
    {

        $contato = [
            'nome' => 'Edy',
            'setor' => 'GETEC',
            'ramalOuTelefone' => '3411'
        ];

        $modelo = new Contato();
        $modelo->setNome('Edy')->setSetor('GETEC')->setRamalOuTelefone('3411');

        $repository = $this->prophesize(RepositorioInterface::class);

        $repository->adicionar($modelo);

        $contatoServico = new ContatoServico();

        $contatoServico->adicionarContato($contato);


    }
}
