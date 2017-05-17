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

    public function adicionar(ModeloInterface $modelo): ModeloInterface
    {
        $this->entityManager->persist($modelo);
        $this->entityManager->flush();

        return $modelo;
    }

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
        };

        return $contato;
    }

    public function atualizar(ModeloInterface $modelo): ModeloInterface
    {
        $modelo->setUpdatedAt(new \DateTime("now"));

        $this->entityManager->persist($modelo);
        $this->entityManager->flush();

        return $modelo;
    }

    public function excluir(ModeloInterface $modelo): bool
    {
        $modelo->setDeletedAt(new \DateTime("now"));
        $this->entityManager->persist($modelo);
        $this->entityManager->flush();

        return true;
    }

    public function listar(array $parametros): array
    {
        $contato = $this->entityManager
                        ->getRepository($this->modelo)
                        ->findBy(
                            [
                                'usuario' => $parametros['usuario'],
                                'deletedAt' => null
                            ]
                        );
        if ($contato === null) {
            return [];
        };

        return $contato;
    }
}
