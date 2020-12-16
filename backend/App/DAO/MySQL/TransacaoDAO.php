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

    public function getPeriodByConta(int $idConta, DateTime $initial, DateTime $final):array
    {

    }

    public function getById(int $id): ?TransacaoModel
    {

    }


    public function insert(TransacaoModel $post): TransacaoModel
    {

    }

}
