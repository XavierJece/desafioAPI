<?php

namespace App\DAO\MySQL;

use App\DAO\MySQL\Connection;
use App\Models\MySQL\{
    ContaModel
};

class ContaDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll(): array
    {

    }

    public function getById(int $id): ?ContaModel
    {
        $statement = $this->pdo
                ->prepare('SELECT * FROM `contas`
                        WHERE `idConta` = :id;');
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);

        $statement->execute();

        $dataConta= $statement->fetchAll(\PDO::FETCH_ASSOC);

        if(count($dataConta) === 0){
            return null;
        }

        $conta = new ContaModel();

        $conta->setIdConta($dataConta[0]['idConta'])
            ->setIdPessoa($dataConta[0]['idPessoa'])
            ->setSaldo($dataConta[0]['saldo'])
            ->setLimiteSaqueDiario($dataConta[0]['limiteSaqueDiario'])
            ->setFlagAtivo($dataConta[0]['flagAtivo'])
            ->setTipoConta($dataConta[0]['tipoConta'])
            ->setDataCriacao($dataConta[0]['dataCriacao']);

        return $conta;
    }

    public function getByPessoa(int $idPessoa): ?ContaModel
    {
        $statement = $this->pdo
                ->prepare('SELECT * FROM `contas`
                        WHERE `idPessoa` = :idPessoa;');
        $statement->bindValue(':idPessoa', $idPessoa, \PDO::PARAM_INT);

        $statement->execute();

        $dataConta= $statement->fetchAll(\PDO::FETCH_ASSOC);

        if(count($dataConta) === 0){
            return null;
        }

        $conta = new ContaModel();

        $conta->setIdConta($dataConta[0]['idConta'])
            ->setIdPessoa($dataConta[0]['idPessoa'])
            ->setSaldo($dataConta[0]['saldo'])
            ->setLimiteSaqueDiario($dataConta[0]['limiteSaqueDiario'])
            ->setFlagAtivo($dataConta[0]['flagAtivo'])
            ->setTipoConta($dataConta[0]['tipoConta'])
            ->setDataCriacao($dataConta[0]['dataCriacao']);

        return $conta;
    }


    public function update(ContaModel $conta): ContaModel
    {
        $statement = $this->pdo
                ->prepare('UPDATE `contas`
                SET
                    `idPessoa` = :idPessoa,
                    `saldo` = :saldo,
                    `limiteSaqueDiario` = :limiteSaqueDiario,
                    `flagAtivo`= :flagAtivo,
                    `tipoConta`= :tipoConta,
                    `dataCriacao`= :dataCriacao
                WHERE
                    `idConta`= :id;'
                );
        $statement->bindValue(':id', $conta->getIdConta(), \PDO::PARAM_INT);
        $statement->bindValue(':idPessoa', $conta->getIdPessoa());
        $statement->bindValue(':saldo', $conta->getSaldo());
        $statement->bindValue(':limiteSaqueDiario', $conta->getLimiteSaqueDiario());
        $statement->bindValue(':flagAtivo', $conta->getFlagAtivo());
        $statement->bindValue(':tipoConta', $conta->getTipoConta());
        $statement->bindValue(':dataCriacao', $conta->getDataCriacao());

        $statement->execute();

        return $conta;
    }

    public function insert(ContaModel $conta): ?ContaModel
    {
        $statement = $this->pdo
                ->prepare('INSERT INTO `contas`
                    (`idPessoa`, `limiteSaqueDiario`, `tipoConta`, `dataCriacao`)
                    VALUES (:idPessoa, :limiteSaqueDiario, :tipoConta, current_timestamp());'
                );
        $statement->bindValue(':idPessoa', $conta->getIdPessoa(), \PDO::PARAM_INT);
        $statement->bindValue(':limiteSaqueDiario', $conta->getLimiteSaqueDiario());
        $statement->bindValue(':tipoConta', $conta->getTipoConta());
        $statement->execute();

        return $this->getByPessoa($conta->getIdPessoa());

    }

    public function ativar(int $id): ContaModel
    {

    }

    public function desativar(int $id): void
    {

    }
}
