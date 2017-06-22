<?php
declare(strict_types=1);

namespace AppTest\ContatoModulo\Aplicacao\Excel;

use ContatoModulo\Aplicacao\Excel\LeitorArquivoExcel;
use PHPUnit\Framework\TestCase;

/**
 * Class LeitorArquivoExcelTest
 *
 * @package AppTest\ContatoModulo\Aplicacao\Excel
 * @group Excel
 */
class LeitorArquivoExcelTest extends TestCase
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

        $leitor = new LeitorArquivoExcel();
        $conteudo = $leitor->getConteudo($arquivo);

        $this->assertInternalType('array', $conteudo);
        $this->assertNotEmpty($conteudo);
        $this->assertArrayHasKey('nome', $conteudo[0]);
        $this->assertArrayHasKey('setor', $conteudo[0]);
        $this->assertArrayHasKey('ramalOuTelefone', $conteudo[0]);
    }
}
