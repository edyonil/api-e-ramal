<?php
declare(strict_types=1);

namespace ContatoModulo\Aplicacao\Excel;

/**
 * Class LeitorArquivoExcel
 *
 * @package ContatoModulo\Aplicacao\Excel
 */
class LeitorArquivoExcel
{
    /**
     * @param string $arquivo
     * @return array
     * @throws \Exception
     */
    public function getConteudo(string $arquivo): array
    {
        $excel = \PHPExcel_IOFactory::load($arquivo);

        $sheet = $excel->getSheetByName('ramais');

        if (is_null($sheet)) {
            throw new \Exception('O arquivo deve conter uma pasta chamada "ramais".');
        }

        $linhas = $sheet->toArray(null, false, true, true);

        $dados = [];

        foreach ($linhas as $k => $l) {
            if ($k > 1) {
                $dados[] = [
                    'nome' => trim($l['A']),
                    'setor' => trim(mb_strtoupper((string)$l['B'], 'utf-8')),
                    'ramalOuTelefone' => trim((string)$l['C']),
                ];
            }
        }

        return $dados;
    }
}
