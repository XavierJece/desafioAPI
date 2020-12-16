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

    public function getAllByConta(int $idConta): array
    {

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
