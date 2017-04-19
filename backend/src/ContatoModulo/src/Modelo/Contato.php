<?php declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: ediaimoborges
 * Date: 16/04/17
 * Time: 21:43
 */

namespace ContatoModulo\Modelo;

/**
 * Modelo Contato
 *
 * Class Contato
 *
 * @package ContatoModulo\Modelo
 */
class Contato implements ModeloInterface
{
    private $id;

    private $nome;

    private $setor;

    private $ramalOuTelefone;

    private $usuario;

    private $createdAt;

    private $updatedAt;

    private $deletedAt;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * @param mixed $nome
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSetor()
    {
        return $this->setor;
    }

    /**
     * @param mixed $setor
     */
    public function setSetor($setor)
    {
        $this->setor = $setor;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRamalOuTelefone()
    {
        return $this->ramalOuTelefone;
    }

    /**
     * @param mixed $ramalOuTelefone
     */
    public function setRamalOuTelefone($ramalOuTelefone)
    {
        $this->ramalOuTelefone = $ramalOuTelefone;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @param mixed $usuario
     */
    public function setUsuario(Usuario $usuario) : Contato
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Registra o registro removido
     *
     * @param date $deletedAt Data de exclusão do registro
     *
     * @return $this
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }


    /**
     * Trata os campos para o front
     *
     * @return array Atributos retornados
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'setor' =>$this->getSetor(),
            'ramalOuTelefone' => $this->getRamalOuTelefone(),
            'usuario' => $this->getUsuario()->toArray(),
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt(),
            'deletedAt' => $this->getDeletedAt()
        ];
    }


}