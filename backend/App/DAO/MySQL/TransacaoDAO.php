<?php

namespace App\DAO\MySQL;

use App\DAO\MySQL\Connection;
use App\Models\MySQL\{
    TransacaoModel
};
use DateTime;

class TransacaoDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllByConta(int $idConta, string $initial, string $final): array
    {
        $statement = $this->pdo
                ->prepare('SELECT `idTransacao`, `idConta`, `valor`, `dataTransacao`
                    FROM `transacoes`
                        WHERE
                            `idConta` = :idConta
                        AND `dataTransacao` between :dateInitial and :dateFinal
                        ORDER by `dataTransacao`   DESC;');
        $statement->bindValue(':idConta', $idConta, \PDO::PARAM_INT);
        $statement->bindValue(':dateInitial', $initial);
        $statement->bindValue(':dateFinal', $final);
        $statement->execute();

        $transacoes= $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $transacoes;
    }

    public function getTotalWithdrawToday(int $idConta): int
    {
        $statement = $this->pdo
                ->prepare('SELECT (SUM(valor) * -1) as "saqueToday"
                    FROM `transacoes`
                    WHERE `dataTransacao` BETWEEN CONCAT(CURDATE(), " 00:00:00") AND CONCAT(CURDATE(), " 23:59:59")
                    AND `idConta` = :idConta
                    AND valor < 0;');
        $statement->bindValue(':idConta', $idConta, \PDO::PARAM_INT);
        $statement->execute();

        $res= $statement->fetchAll(\PDO::FETCH_ASSOC);

        if(count($res) === 0){
            return 0;
        }

        return $res[0]['saqueToday'];

    }

    public function insert(int $idConta, float $valor): void
    {

        $statement = $this->pdo
                ->prepare('INSERT INTO `transacoes`
                    (`idConta`, `valor`, dataTransacao) VALUES
                    (:idConta, :valor, current_timestamp());');
        $statement->bindValue(':idConta', $idConta, \PDO::PARAM_INT);
        $statement->bindValue(':valor', $valor);
        $statement->execute();

    }

}
