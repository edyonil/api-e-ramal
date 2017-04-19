<?php

declare(strict_types=1);

namespace ContatoModulo\Aplicacao\Contato;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoInterface;
use ContatoModulo\Infraestrutura\Repositorio\RepositorioInterface;
use ContatoModulo\Modelo\Contato;

/**
 * Class ContatoService
 *
 * @category Contato
 * @package  ContatoModulo\Aplicacao\Contato
 * @author   Edy <edyonil@gmail.com>
 * @license  GPL http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     api.com
 */
class ContatoService
{

    /**
     * @var RepositorioInterface
     */
    private $repositorio;

    /**
     * @var AutenticacaoInterface
     */
    private $autenticacao;

    /**
     * ContatoService constructor.
     *
     * @param RepositorioInterface  $repositorio
     * @param AutenticacaoInterface $autenticacao
     */
    public function __construct(
        RepositorioInterface $repositorio,
        AutenticacaoInterface $autenticacao
    ) {

        $this->repositorio = $repositorio;
        $this->autenticacao = $autenticacao;
    }

    /**
     * @param array $input
     *
     * @return array
     */
    public function adicionarContato(array $input): array
    {

        $contato = new Contato();
        $contato->setNome($input['nome'])
            ->setSetor($input['setor'])
            ->setRamalOuTelefone($input['ramalOuTelefone'])
            ->setUsuario($this->autenticacao->obterUsuarioAutenticado());

        $contato = $this->repositorio->adicionar($contato);

        return $contato->toArray();
    }

    /**
     * @param int   $id
     * @param array $input
     *
     * @return array
     */
    public function editarContato(int $id, array $input): array
    {

        $contato = $this->repositorio->encontrar($id);

        $contato->setNome($input['nome'])
            ->setSetor($input['setor'])
            ->setRamalOuTelefone($input['ramalOuTelefone'])
            ->setUsuario($this->autenticacao->obterUsuarioAutenticado());

        $contato = $this->repositorio->atualizar($contato);

        return $contato->toArray();
    }

    /**
     * @param int $id
     *
     * @return array
     */
    public function localizarContato(int $id) : array
    {
        $contato = $this->repositorio->encontrar($id);
        return $contato->toArray();
    }

    /**
     * @param array $input
     *
     * @return array
     */
    public function listarContato(array $input) : array
    {
        $retorno = [];
        $contato = $this->repositorio->listar($input);

        foreach ($contato as $item) {
            $retorno['itens'][] = $item->toArray();
        }

        $retorno['total'] = $retorno['itens'];
        return $retorno;
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function excluirContato(int $id) : bool
    {

        $usuario = $this->repositorio->encontrar($id);

        return $this->repositorio->excluir($usuario);
    }



}