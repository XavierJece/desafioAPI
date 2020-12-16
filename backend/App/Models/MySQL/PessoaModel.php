<?php

namespace App\Models\MySQL;

final class PessoaModel
{


    /**
     * @var int
     */
    private $idPessoa;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $cpf;

    /**
     * @var string
     */
    private $dataNascimento;


// Gets

    /**
     * @return int
     */
    public function getIdPessoa(): int
    {
        return $this->idPessoa;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @return string
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * @return string
     */
    public function getDataNascimento(): string
    {
        return $this->dataNascimento;
    }


// Sets

    /**
     * @param int $id
     * @return self
     */
    public function setIdPessoa(int $id): self
    {
        $this->idPessoa = $id;
        return $this;
    }

    /**
     * @param string $nome
     * @return self
     */
    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * @param string $cpf
     * @return self
     */
    public function setCpf(string $cpf): self
    {
        $this->cpf = $cpf;
        return $this;
    }

    /**
     * @param string $dataNascimento
     * @return self
     */
    public function setDataNascimento(string $dataNascimento): self
    {
        $this->dataNascimento = $dataNascimento;
        return $this;
    }

}
