<?php
declare(strict_types=1);

namespace ContatoModulo\Aplicacao\Contato;

use ContatoModulo\Aplicacao\Autenticacao\AutenticacaoInterface;
use ContatoModulo\Infraestrutura\Persistencia\Repositorio\RepositorioInterface;
use ContatoModulo\Modelo\Contato;

/**
 * Class ContatoService
 *
 * @category Contato
 * @package  ContatoModulo\Aplicacao\Contato
 * @author   Edy <edyonil@gmail.com>
 * @license  GPL http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/edyonil/api-e-ramal
 */
class ContatoService
{
    /**
     * Repositorio
     *
     * @var RepositorioInterface
     */
    private $repositorio;

    /**
     * Autenticação
     *
     * @var AutenticacaoInterface
     */
    private $autenticacao;

    /**
     * ContatoService constructor.
     *
     * @param RepositorioInterface $repositorio Classe de Repositorio
     * @param AutenticacaoInterface $autenticacao Classe de autenticação
     */
    public function __construct(
        RepositorioInterface $repositorio,
        AutenticacaoInterface $autenticacao
    ) {
        $this->repositorio = $repositorio;
        $this->autenticacao = $autenticacao;
    }

    /**
     * Responsável por adicionar um contato
     *
     * @param array $input Campos que serão adicionados ao contato
     *                     Deve ser enviado os seguintes campos
     *                     nome, setor, ramalOuTelefone
     *
     * @return array
     */
    public function adicionarContato(array $input): array
    {
        $contato = new Contato();
        $usuario = $this->autenticacao->obterUsuarioAutenticado($input['token']);
        $contato->setNome($input['nome'])
            ->setSetor(mb_strtoupper($input['setor'], 'utf-8'))
            ->setRamalOuTelefone($input['ramalOuTelefone'])
            ->setUsuario($usuario);

        $contato = $this->repositorio->adicionar($contato);

        return $contato->toArray();
    }

    /**
     * Responsável por localizar e editar um contato
     *
     * @param int $id Identificador do contato na lista
     * @param array $input Campos que serão atualizados do contato
     *                     Deve ser enviado os seguintes campos
     *                     nome, setor, ramalOuTelefone
     *
     * @return array
     */
    public function editarContato(int $id, array $input): array
    {
        $contato = $this->repositorio->encontrar($id);

        $usuario = $this->autenticacao->obterUsuarioAutenticado($input['token']);

        $contato->setNome($input['nome'])
            ->setSetor(mb_strtoupper($input['setor'], 'utf-8'))
            ->setRamalOuTelefone($input['ramalOuTelefone'])
            ->setUsuario($usuario);

        $contato = $this->repositorio->atualizar($contato);

        return $contato->toArray();
    }

    /**
     * Responsável em localizar um contato
     *
     * @param int $id Identificador do contato na lista
     * @return array
     */
    public function localizarContato(int $id): array
    {
        $contato = $this->repositorio->encontrar($id);

        return $contato->toArray();
    }

    /**
     * Lista todos os contatos cadastros no sistema para o usuário
     *
     * @param array $input Parametros para filtros da lista de contatos
     * @return array
     */
    public function listarContato(array $input): array
    {
        $retorno = [];

        $usuario = $this->autenticacao->obterUsuarioAutenticado($input['token']);
        $input['usuario'] = $usuario->getId();

        $contato = $this->repositorio->listar($input);

        if (count($contato) === 0) {
            $retorno['itens'] = [];
            $retorno['total'] = 0;

            return $retorno;
        }

        foreach ($contato as $k => $item) {
            $retorno['itens'][$k] = $item->toArray();
            $retorno['itens'][$k]['ordem'] = $k + 1;
        }

        $retorno['total'] = count($retorno['itens']);

        return $retorno;
    }

    /**
     * Responsável por excluir contatos da lista
     *
     * @param int $id Identificador do contato na lista
     * @return bool
     */
    public function excluirContato(int $id): bool
    {
        $usuario = $this->repositorio->encontrar($id);

        return $this->repositorio->excluir($usuario);
    }
}
