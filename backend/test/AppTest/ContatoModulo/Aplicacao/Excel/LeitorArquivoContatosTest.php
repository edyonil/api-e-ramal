<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Aplicacao\Excel;

use ContatoModulo\Aplicacao\Excel\LeitorArquivoContatos;
use PHPUnit\Framework\TestCase;

/**
 * Class LeitorArquivoContatosTest
 *
 * @package AppTest\ContatoModulo\Aplicacao\Excel
 * @group Excel
 */
class LeitorArquivoContatosTest extends TestCase
{
    public function testLerOConteudoDeUmArquivoExcel()
    {
        $arquivo = __DIR__ . "/../../../../../public/importacao-e-ramal.xlsx";

        $output = [
            [
                'nome' => 'Alex Gomes',
                'setor' => 'GETEC',
                'ramalOuTelefone' => '3411',
            ],
            [
                'nome' => 'Alex Gomes',
                'setor' => 'GETEC',
                'ramalOuTelefone' => '3411',
            ],
            [
                'nome' => 'Alex Gomes',
                'setor' => 'GETEC',
                'ramalOuTelefone' => '3411',
            ],
        ];

        $leitor = new LeitorArquivoContatos();
        $conteudo = $leitor->getConteudo($arquivo);

        $this->assertInternalType('array', $conteudo);
        $this->assertNotEmpty($conteudo);
        $this->assertArrayHasKey('nome', $conteudo[0]);
        $this->assertArrayHasKey('setor', $conteudo[0]);
        $this->assertArrayHasKey('ramalOuTelefone', $conteudo[0]);
    }
}
