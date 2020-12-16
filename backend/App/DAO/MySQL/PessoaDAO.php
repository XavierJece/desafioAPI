<?php

namespace App\DAO\MySQL;

use App\DAO\MySQL\Connection;
use App\Models\MySQL\{
    PessoaModel
};

class PessoaDAO extends Connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getById(int $id): ?PessoaModel
    {
        $statement = $this->pdo
                ->prepare('SELECT * FROM `pessoas`
                        WHERE `idPessoa` = :id;');
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);

        $statement->execute();

        $dataPessoa= $statement->fetchAll(\PDO::FETCH_ASSOC);

        if(count($dataPessoa) === 0){
            return null;
        }

        $pessoa = new PessoaModel();

        $pessoa->setIdPessoa($dataPessoa[0]['idPessoa'])
            ->setNome($dataPessoa[0]['nome'])
            ->setCpf($dataPessoa[0]['cpf'])
            ->setDataNascimento($dataPessoa[0]['dataNascimento']);

        return $pessoa;
    }
}
