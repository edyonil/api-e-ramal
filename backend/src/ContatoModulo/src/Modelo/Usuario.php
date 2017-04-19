<?php declare(strict_types=1);

namespace ContatoModulo\Modelo;

class Usuario implements ModeloInterface
{
    private $id;

    private $nome;

    private $email;

    private $password;

    private $ativo = false;

    private $primeiroAcesso = true;

    private $compartilharContatos = true;

    private $createdAt;

    private $updatedAt;

    private $deletedAt;

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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return bool
     */
    public function ativo(): bool
    {
        return $this->ativo;
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
     * @return bool
     */
    public function primeiroAcesso(): bool
    {
        return $this->primeiroAcesso;
    }

    /**
     * @param bool $primeiroAcesso
     */
    public function setPrimeiroAcesso(bool $primeiroAcesso)
    {
        $this->primeiroAcesso = $primeiroAcesso;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCompartilharContatos()
    {
        return $this->compartilharContatos;
    }

    /**
     * @param mixed $compartilharContatos
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
     * @param mixed $deletedAt
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'nome' => $this->getNome(),
            'email' => $this->getEmail(),
            'ativo' =>$this->ativo(),
            'primeiroAcesso' => $this->primeiroAcesso(),
            'compartilharContatos' => $this->getCompartilharContatos(),
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt(),
            'deletedAt' => $this->getDeletedAt()
        ];
    }


}