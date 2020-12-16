<?php

namespace App\Models\MySQL;

use DateTime;

final class ContaModel
{


    /**
     * @var int
     */
    private $idConta;

    /**
     * @var int
     */
    private $idPessoa;

    /**
     * @var self
     */
    private $saldo;

    /**
     * @var float
     */
    private $limiteSaqueDiario;

    /**
     * @var bool
     */
    private $flagAtivo;

    /**
     * @var int
     */
    private $tipoConta;

    /**
     * @var DateTime
     */
    private $dataCriacao;


    // Gets

    /**
     * @return int
     */
    public function getIdConta(): int
    {
        return $this->idConta;
    }

    /**
     * @return int
     */
    public function getIdPessoa(): int
    {
        return $this->idPessoa;
    }

    /**
     * @return float
     */
    public function getSaldo(): float
    {
        return $this->saldo;
    }

    /**
     * @return self
     */
    public function getLimiteSaqueDiario(): float
    {
        return $this->limiteSaqueDiario;
    }

    /**
     * @return bool
     */
    public function getFlagAtivo(): bool
    {
        return $this->flagAtivo;
    }

    /**
     * @return int
     */
    public function getTipoConta(): int
    {
        return $this->tipoConta;
    }

    /**
     * @return DateTime
     */
    public function getDataCriacao(): DateTime
    {
        return $this->dataCriacao;
    }


    // Sets

    /**
     * @param string $id
     * @return self
     */
    public function setIdConta(int $id): self
    {
        $this->idConta = $id;
        return $this;
    }

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
     * @param float $limiteSaqueDiario
     * @return self
     */
    public function setLimiteSaqueDiario(float $limiteSaqueDiario): self
    {
        $this->limiteSaqueDiario = $limiteSaqueDiario;
        return $this;
    }

    /**
     * @param bool $status
     * @return self
     */
    public function setFlagAtivo(bool $status): self
    {
         $this->flagAtivo = $status;
        return $this;
    }

    /**
     * @param string $tipoConta
     * @return self
     */
    public function setTipoConta(int $tipoConta): self
    {
        $this->tipoConta = $tipoConta;
        return $this;
    }

    /**
     * @param DateTime $dataCriacao
     * @return self
     */
    public function setDataCriacao(DateTime $dataCriacao): self
    {
        $this->dataCriacao = $dataCriacao;
        return $this;
    }

}
