<?php
declare(strict_types=1);

namespace ContatoModulo\Aplicacao\Usuario;

use ContatoModulo\Infraestrutura\Persistencia\Repositorio\RepositorioInterface;
use ContatoModulo\Modelo\Usuario;

/**
 * Class UsuarioServico
 *
 * @category Usuario
 * @package  ContatoModulo\Aplicacao\Contato
 * @author   Alex Gomes <alexrsg@gmail.com>
 * @license  GPL http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     https://github.com/edyonil/api-e-ramal
 */
class UsuarioServico
{
    /**
     * @var RepositorioInterface
     */
    private $repositorio;

    /**
     * UsuarioServico constructor.
     *
     * @param RepositorioInterface $repositorio
     */
    public function __construct(RepositorioInterface $repositorio)
    {
        $this->repositorio = $repositorio;
    }

    /**
     * @param array $input
     * @return array
     */
    public function adicionarUsuario(array $input): array
    {
        $usuario = new Usuario();
        $usuario->setAtivo(true)
            ->setCompartilharContatos($input['compartilharContatos'])
            ->setEmail($input['email'])
            ->setNome($input['nome'])
            ->setPassword($input['password'])
            ->setPrimeiroAcesso(true);

        $usuario = $this->repositorio->adicionar($usuario);

        return $usuario->toArray();
    }

    /**
     * @param int $id
     * @param array $input
     * @return array
     */
    public function editarUsuario(int $id, array $input): array
    {
        $usuario = $this->repositorio->encontrar($id);

        $usuario->setAtivo($input['ativo'])
            ->setCompartilharContatos($input['compartilharContatos'])
            ->setEmail($input['email'])
            ->setNome($input['nome'])
            ->setPassword($input['password'])
            ->setPrimeiroAcesso($input['primeiroAcesso']);

        $usuario = $this->repositorio->atualizar($usuario);

        return $usuario->toArray();
    }

    /**
     * @param int $id
     * @return array
     */
    public function localizarUsuario(int $id): array
    {
        $usuario = $this->repositorio->encontrar($id);

        return $usuario->toArray();
    }

    /**
     * @param array $input
     * @return array
     */
    public function listarUsuario(array $input): array
    {
        $dados = [];

        $usuario = $this->repositorio->listar($input);

        foreach ($usuario as $u) {
            $dados['itens'][] = $u->toArray();
        }

        $dados['total'] = count($dados['itens']);

        return $dados;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function excluirUsuario(int $id): bool
    {
        $usuario = $this->repositorio->encontrar($id);

        return $this->repositorio->excluir($usuario);
    }
}
