<?php
declare(strict_types=1);
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
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $setor;

    /**
     * @var string
     */
    private $ramalOuTelefone;

    /**
     * @var Usuario
     */
    private $usuario;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var string
     */
    private $updatedAt;

    /**
     * @var string
     */
    private $deletedAt = null;

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
     * @param $nome
     * @return $this
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
     * @param $setor
     * @return $this
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
     * @param $ramalOuTelefone
     * @return $this
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
     * @param Usuario $usuario
     * @return Contato
     */
    public function setUsuario(Usuario $usuario): Contato
    {
        $usuario->setListaContatos($this);

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
     * @param $createdAt
     * @return $this
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
     * @param $updatedAt
     * @return $this
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
            'setor' => $this->getSetor(),
            'ramalOuTelefone' => $this->getRamalOuTelefone(),
            'usuario' => $this->getUsuario()->toArray(),
            'createdAt' => $this->tratarData($this->getCreatedAt()),
            'updatedAt' => $this->tratarData($this->getUpdatedAt()),
            'deletedAt' => $this->tratarData($this->getDeletedAt()),
        ];
    }

    /**
     * Trata a data do formato \DateTime para o formato BR
     *
     * @param \DateTime|null $data
     * @return string
     */
    protected function tratarData(\DateTime $data = null): string
    {
        return is_null($data) ? '' : $data->format('d/m/Y H:i:s');
    }
}
