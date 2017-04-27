<?php
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 27/04/17
 * Time: 15:53
 */

namespace ContatoModulo\Infraestrutura\Persistencia\Contato\Repositorio;


use ContatoModulo\Infraestrutura\Persistencia\Repositorio\RepositorioInterface;
use ContatoModulo\Modelo\Contato;
use ContatoModulo\Modelo\ModeloInterface;
use Doctrine\ORM\EntityManager;

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
        $contato = $this->entityManager->find($this->modelo, $id);

        if ($contato === null) {
            throw new \Exception('Registro não encontrado');
        };

        return $contato;
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
        // TODO: Implement excluir() method.
    }

    public function listar(array $parametros): array
    {
        // TODO: Implement listar() method.
    }
}
