<?php

namespace App\Models\MySQL;

use DateTime;

final class TransacaoModel
{


    /**
     * @var int
     */
    private $idTransacao;

    /**
     * @var int
     */
    private $idConta;

    /**
     * @var float
     */
    private $valor;

    /**
     * @var DateTime
     */
    private $dataTransacao;


// Gets

    /**
     * @return int
     */
    public function getIdTransacao(): int
    {
        return $this->idTransacao;
    }

    /**
     * @return int
     */
    public function getIdConta(): int
    {
        return $this->idConta;
    }

    /**
     * @return float
     */
    public function getValor(): float
    {
        return $this->valor;
    }

    /**
     * @return DateTime
     */
    public function getDataTransacao(): DateTime
    {
        return $this->dataTransacao;
    }


// Sets

    /**
     * @param int $id
     * @return self
     */
    public function setIdTransacao(int $id): self
    {
        $this->idTransacao = $id;
        return $this;
    }

    /**
     * @param int $idConta
     * @return self
     */
    public function setIdConta(int $idConta): self
    {
        $this->idConta = $idConta;
        return $this;
    }

    /**
     * @param float $valor
     * @return self
     */
    public function setValor(float $valor): self
    {
        $this->valor = $valor;
        return $this;
    }

    /**
     * @param DateTime $dataTransacao
     * @return self
     */
    public function setDataTransacao(DateTime $dataTransacao): self
    {
        $this->dataTransacao = $dataTransacao;
        return $this;
    }

}
