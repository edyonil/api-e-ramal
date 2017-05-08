<?php
declare(strict_types=1);

namespace ContatoModulo\Infraestrutura\Persistencia\Repositorio\Usuario;

use ContatoModulo\Infraestrutura\Persistencia\Repositorio\RepositorioInterface;
use ContatoModulo\Modelo\Usuario;
use ContatoModulo\Modelo\ModeloInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class ContatoRepositorio
 *
 * @package ContatoModulo\Infraestrutura\Persistencia\Usuario\Repositorio
 */
class UsuarioRepositorio implements RepositorioInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var Usuario $modelo
     */
    private $modelo;

    private $fields = [
        'email',
        'nome',
        'password',
        'ativo',
        'primeiroAcesso',
        '$compartilharContatos',
    ];

    /**
     * ContatoRepositorio constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->modelo = Usuario::class;
    }

    public function adicionar(ModeloInterface $modelo): ModeloInterface
    {
        $this->entityManager->persist($modelo);
        $this->entityManager->flush();

        return $modelo;
    }

    public function encontrar(int $id): ModeloInterface
    {
        $usuario = $this->entityManager->find($this->modelo, $id);

        if ($usuario === null) {
            throw new \Exception('Registro não encontrado.');
        }

        return $usuario;
    }

    public function atualizar(ModeloInterface $modelo): ModeloInterface
    {
        $modelo->setUpdatedAt(date('Y-m-d H:i:s'));

        $this->entityManager->persist($modelo);
        $this->entityManager->flush();

        return $modelo;
    }

    public function excluir(ModeloInterface $modelo): bool
    {
        $this->entityManager->remove($modelo);
        $this->entityManager->flush();

        return true;
    }

    public function listar(array $parametros): array
    {
        $filtros = [];

        if (!empty($parametros)) {
            foreach ($this->fields as $f) {
                if (isset($parametros[$f])) {
                    $filtros[$f] = $parametros[$f];
                }
            }
        }

        return $this->entityManager->findBy($filtros);
    }
}
