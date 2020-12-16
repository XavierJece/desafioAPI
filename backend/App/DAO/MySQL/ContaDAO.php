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

    }


    public function insert(ContaModel $post): ContaModel
    {

    }

    public function ativar(int $id): ContaModel
    {

    }

    public function desativar(int $id): void
    {

    }
}
