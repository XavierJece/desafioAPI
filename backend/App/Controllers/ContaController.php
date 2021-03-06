<?php

namespace App\Controllers;

use App\DAO\MySQL\ContaDAO;
use App\DAO\MySQL\PessoaDAO;
use App\Models\MySQL\ContaModel;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class ContaController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        try{

            $contaDAO = new ContaDAO();
            $contas = $contaDAO->getAll();

            $response->getBody()->write(
                json_encode(
                    $contas,
                    JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
                )
            );

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);

        }catch(\Exception | \Throwable $ex) {
            $error = [
                'status' => "error",
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

    public function create(Request $request, Response $response, array $args): Response
    {
        try{
            $data = $request->getParsedBody();
            $idPessoa = $data['idPessoa'];
            $limiteSaqueDiario = $data['limiteSaqueDiario'];
            $tipoConta = $data['tipoConta'];

            // Verificar se idPessoa está sendo passado
            if(is_null($idPessoa) || empty($idPessoa)){
                throw new Exception("id da  pessoa não encontrado");
            }

            // Verificando se pessoa existe
            $pessoaDAO = new PessoaDAO();
            $pessoa = $pessoaDAO->getById($idPessoa);

            if(!isset($pessoa)){
                throw new Exception("Pessoa não encontrada");
            }

            // Verificando se pessoa jé tem conta
            $contaDAO = new ContaDAO();
            $conta = $contaDAO->getByPessoa($idPessoa);

            if(isset($conta)){
                throw new Exception("Está pessoa já possui uma conta. Entre em contato com o banco para mais informações :D");
            }

            // Verificar se tipo de conta existe

            // Verificar se tipoConta está sendo passado
            if(is_null($tipoConta) || empty($tipoConta)){
                throw new Exception("Tipo de conta não encontrado");
            }

            // Valores para ilustrativos
            $typeContaAllowed = [
                "CORRENTE" => 10,
                "POUPANÇA" => 13,
                "MEI" => 25,
                "UNIVERSITÁRIO" => 17,
            ];

            if(!array_key_exists($tipoConta, $typeContaAllowed)){
                throw new Exception("Tipo de conta inválido");
            }

            //Verificando limiteSaqueDiario

            // Verificar limiteSaqueDiario
            if(is_null($limiteSaqueDiario) || empty($limiteSaqueDiario)){
                throw new Exception("O limite de saque de diário não encontrado");
            }else if($limiteSaqueDiario <= 0){
                throw new Exception("O limite de saque de diário deve ser maior que 0 (zero).");
            }

            // cadastrando conta
            $conta = new ContaModel();
            $conta->setIdPessoa($idPessoa)
                ->setTipoConta($typeContaAllowed[$tipoConta])
                ->setLimiteSaqueDiario(round($limiteSaqueDiario, 2));

            $conta = $contaDAO->insert($conta);



            $response->getBody()->write(
                json_encode(
                    [
                        "idConta" => $conta->getIdConta(),
                        "idPessoa" => $conta->getIdPessoa(),
                        "saldo" => round($conta->getSaldo(), 2),
                        "limiteSaqueDiario" => round($conta->getLimiteSaqueDiario(), 2),
                        "flagAtivo" => $conta->getFlagAtivo(),
                        "tipoConta" => $conta->getTipoConta(),
                        "dataCriacao" => $conta->getDataCriacao()
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

    public function show(Request $request, Response $response, array $args): Response
    {
        try{

            $idConta = intval($args['idConta'], 10);

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

            $pessoaDAO = new PessoaDAO();
            $pessoa = $pessoaDAO->getById($conta->getIdPessoa());

            $response->getBody()->write(
                json_encode(
                    [
                        "idConta" => $conta->getIdConta(),
                        "idPessoa" => $conta->getIdPessoa(),
                        "saldo" => round($conta->getSaldo(), 2),
                        "limiteSaqueDiario" => round($conta->getLimiteSaqueDiario(), 2),
                        "flagAtivo" => $conta->getFlagAtivo(),
                        "tipoConta" => $conta->getTipoConta(),
                        "dataCriacao" => $conta->getDataCriacao(),
                        "pessoa" => [
                            "idPessoa" => $pessoa->getIdPessoa(),
                            "nome" => $pessoa->getNome(),
                            "cpf" => $pessoa->getCPF(),
                            "dataNascimento" => $pessoa->getDataNascimento(),
                        ]

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
