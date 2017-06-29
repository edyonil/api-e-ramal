<?php
declare(strict_types=1);

namespace ContatoModulo\Modelo;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Usuario
 *
 * @package ContatoModulo\Modelo
 */
class Usuario implements ModeloInterface
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
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var bool
     */
    private $ativo = false;

    /**
     * @var bool
     */
    private $primeiroAcesso = true;

    /**
     * @var bool
     */
    private $compartilharContatos = true;

    /**
     * @var ArrayCollection|null
     */
    private $listaContato = null;

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
     * Usuario constructor.
     */
    public function __construct()
    {
        $this->listaContato = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @param bool $ativo
     *
     * @return $this
     */
    public function setAtivo(bool $ativo)
    {
        $this->ativo = $ativo;

        return $this;
    }

    /**
     * @param bool $primeiroAcesso
     * @return $this
     */
    public function setPrimeiroAcesso(bool $primeiroAcesso)
    {
        $this->primeiroAcesso = $primeiroAcesso;

        return $this;
    }

    /**
     * @param Contato $contato
     * @return $this
     */
    public function setListaContatos(Contato $contato)
    {
        $this->listaContato[] = $contato;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'email' => $this->getEmail(),
            'ativo' => $this->getAtivo(),
            'primeiroAcesso' => $this->primeiroAcesso(),
            'compartilharContatos' => $this->getCompartilharContatos(),
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return bool
     */
    public function getAtivo(): bool
    {
        return $this->ativo;
    }

    /**
     * @return bool
     */
    public function primeiroAcesso(): bool
    {
        return $this->primeiroAcesso;
    }

    /**
     * @return mixed
     */
    public function getCompartilharContatos()
    {
        return $this->compartilharContatos;
    }

    /**
     * @param $compartilharContatos
     * @return $this
     */
    public function setCompartilharContatos($compartilharContatos)
    {
        $this->compartilharContatos = $compartilharContatos;

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
     * @param $deletedAt
     * @return $this
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return null
     */
    public function getListaContatos()
    {
        return $this->listaContato;
    }
}
