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
    protected $entityManager;

    /**
     * @var Usuario $modelo
     */
    private $modelo;

    /**
     * @var array
     */
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

    /**
     * @param ModeloInterface $modelo
     * @return ModeloInterface
     */
    public function adicionar(ModeloInterface $modelo): ModeloInterface
    {
        $this->entityManager->persist($modelo);
        $this->entityManager->flush();

        return $modelo;
    }

    /**
     * @param int $id
     * @return ModeloInterface
     * @throws \Exception
     */
    public function encontrar(int $id): ModeloInterface
    {
        $usuario = $this->entityManager->getRepository($this->modelo)->findOneBy([
            'id' => $id,
            'deletedAt' => null,
        ]);

        if ($usuario === null) {
            throw new \Exception('Registro não encontrado.');
        }

        return $usuario;
    }

    /**
     * @param ModeloInterface $modelo
     * @return ModeloInterface
     */
    public function atualizar(ModeloInterface $modelo): ModeloInterface
    {
        $modelo->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($modelo);
        $this->entityManager->flush();

        return $modelo;
    }

    /**
     * @param ModeloInterface $modelo
     * @return bool
     */
    public function excluir(ModeloInterface $modelo): bool
    {
        $modelo->setDeletedAt(new \DateTime());

        $this->entityManager->persist($modelo);
        $this->entityManager->flush();

        return true;
    }

    /**
     * @param array $parametros
     * @return array
     */
    public function listar(array $parametros): array
    {
        $filtros = [];

        if (!empty($parametros)) {
            foreach ($this->fields as $f) {
                if (isset($parametros['filtro'][$f])) {
                    $filtros[$f] = $parametros['filtro'][$f];
                }
            }
        }

        $filtros['deletedAt'] = null;

        return $this->entityManager->getRepository($this->modelo)->findBy($filtros);
    }
}
