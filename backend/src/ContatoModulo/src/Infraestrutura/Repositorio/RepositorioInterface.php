<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 14/04/17
 * Time: 19:24
 */

namespace ContatoModulo\Infraestrutura\Repositorio;

use ContatoModulo\Modelo\ModeloInterface;

interface RepositorioInterface
{
    public function adicionar(ModeloInterface $modelo) : ModeloInterface;
    public function encontrar(int $id) : ModeloInterface;
    public function atualizar(ModeloInterface $modelo) : ModeloInterface;
    public function excluir(ModeloInterface $modelo) : bool;
    public function listar(array $parametros) : array;
}