<?php

namespace App\Controllers;

use App\DAO\MySQL\ContaDAO;
use App\DAO\MySQL\TransacaoDAO;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class DepositoController
{
    public function create(Request $request, Response $response, array $args): Response
    {
        try{

            $idConta = intval($args['idConta'], 10);
            $data = $request->getParsedBody();
            $valor = $data['valor'];

            // Verificar se idConta está sendo passado
            if(is_null($idConta) || empty($idConta)){
                throw new Exception("id da conta não encontrado");
            }

            //Verificar se conta existe
            $contaDAO = new ContaDAO();
            $conta = $contaDAO->getById($idConta);

            //Verificar se a conta está ativa
            if(!isset($conta)){
                throw new Exception('Conta não encontrada');
            }

            // Verificando se conta está ativa
            if($conta->getFlagAtivo() != 1){
                throw new Exception('Não é possível fazer transações um uma conta desativada. Entre em contato com seu gerente para saber mais.');
            }

            //Verificar valor
            if(!isset($valor)){
                throw new Exception("Não foi encontrado nenhum valor para ser depósito");
            }else if(empty($valor)){
                throw new Exception("Digite um valor");
            }else if($valor <= 0){
                throw new Exception("O valor digitado deve ser maior que 0 (zero)");
            }

            // Inserir na tabela transação
            $transacaoDAO = new TransacaoDAO();
            $transacaoDAO->insert($idConta, round($valor, 2));

            // Atualizar Tabela da conta
            $conta->setSaldo($conta->getSaldo() + round($valor, 2));
            $contaDAO->update($conta);

            $response->getBody()->write(
                json_encode(
                    [
                        'status' => 'success',
                        'message' => 'Depósito concluído com sucesso. Alguém deve estar feliz... ;D'
                    ],
                    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
                )
            );

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        }catch(\Exception | \Throwable $ex) {
            $error = [
                'status' => 'error',
                'message' => $ex->getMessage()
            ];

            $response->getBody()->write(
                json_encode(
                    $error,
                    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
                )
            );

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }
    }
}
