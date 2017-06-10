<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 27/04/17
 * Time: 15:53
 */

namespace ContatoModulo\Infraestrutura\Persistencia\Repositorio\Contato;


use ContatoModulo\Infraestrutura\Persistencia\Repositorio\RepositorioInterface;
use ContatoModulo\Modelo\Contato;
use ContatoModulo\Modelo\ModeloInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;

class ContatoRepositorio implements RepositorioInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var array
     */
    private $fields = [
        'nome',
        'ramalOuTelefone',
        'setor',
    ];

    /**
     * @var string
     */
    private $modelo;

    /**
     * ContatoRepositorio constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->modelo = Contato::class;
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
     * @throws NoResultException
     */
    public function encontrar(int $id): ModeloInterface
    {
        $contato = $this->entityManager
            ->getRepository($this->modelo)
            ->findOneBy(
                [
                    'id' => $id,
                    'deletedAt' => null
                ]
            );

        if ($contato === null) {
            throw new NoResultException('Registro não encontrado');
        }

        return $contato;
    }

    /**
     * @param ModeloInterface $modelo
     * @return ModeloInterface
     */
    public function atualizar(ModeloInterface $modelo): ModeloInterface
    {
        $modelo->setUpdatedAt(new \DateTime("now"));

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
        $modelo->setDeletedAt(new \DateTime("now"));
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
        $filtros['usuario'] = $parametros['usuario'];

        $contato = $this->entityManager->getRepository($this->modelo)->findBy($filtros);

        return $contato === null ? [] : $contato;
    }
}
