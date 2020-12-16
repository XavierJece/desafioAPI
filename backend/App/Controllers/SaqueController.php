<?php

namespace App\Controllers;

use App\DAO\MySQL\ContaDAO;
use App\DAO\MySQL\TransacaoDAO;
use DateTime;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class SaqueController
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

            if(!isset($conta)){
                throw new Exception('Conta não encontrada');
            }

            // Verificando se conta está ativa
            if($conta->getFlagAtivo() != 1){
                throw new Exception('Não é possível fazer transações um uma conta desativada. Entre em contato com seu gerente para saber mais.');
            }

            // verificar se ainda não atingiu o limite diário
            $transacaoDAO = new TransacaoDAO();
            $totalSaqueToday = $transacaoDAO->getTotalWithdrawToday($idConta);

            $availableValue = $conta->getLimiteSaqueDiario() - $totalSaqueToday;

            if($availableValue <= 0){
                throw new Exception("O valor de saques diário já foi atingido");
            }

            //Verificar valor
            if(!isset($valor)){
                throw new Exception("Não foi encontrado nenhum valor para ser sacado");
            }else if(empty($valor)){
                throw new Exception("Digite um valor");
            }else if($valor <= 0){
                throw new Exception("O valor digitado deve ser maior que 0 (zero)");
            }else if($valor > $availableValue){
                throw new Exception("Valor ultrapassa a permitido para saque, você ainda pode sacar R$" . round($availableValue, 2));
            }else if($valor > $conta->getSaldo()){
                throw new Exception("Saldo insuficiente, você pode sacar até R$" . round($conta->getSaldo(), 2));
            }

            // Inserir na tabela transação
            $transacaoDAO->insert($idConta, (round($valor, 2) * -1));

            // Atualizar Tabela da conta
            $conta->setSaldo($conta->getSaldo() - round($valor, 2));
            $contaDAO->update($conta);

            $response->getBody()->write(
                json_encode(
                    [
                        'status' => 'success',
                        'message' => 'Saque concluído com sucesso. Aproveite :D'
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
