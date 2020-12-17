<?php

namespace App\Controllers;

use App\DAO\MySQL\ContaDAO;
use App\DAO\MySQL\TransacaoDAO;
use DateTime;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class AtivarContaController
{
    public function update(Request $request, Response $response, array $args): Response
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

            // Atualizar Tabela da conta
            $contaDAO->ativar($idConta);

            $response->getBody()->write(
                json_encode(
                    [
                        'status' => 'success',
                        'message' => 'Conta ativa com sucesso. Hora de gastar! :D'
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
                ->withStatus(400);
        }
    }
}
