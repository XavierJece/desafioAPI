<?php

namespace App\Controllers;

use App\DAO\MySQL\TransacaoDAO;
use DateTime;
use Exception;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class TransacaoController
{
    public function index(Request $request, Response $response, array $args): Response
    {
        try{

            $idConta = intval($args['idConta'], 10);

            if(is_null($idConta) || empty($idConta)){
                throw new Exception("id da conta não encontrado");
            }

            if(!isset($request->getQueryParams('')['dateInitial'])){
                $date1 = new DateTime('1900-01-01 00:00:00');
            }else if(empty($request->getQueryParams('')['dateInitial'])){
                $date1 = new DateTime('1900-01-01 00:00:00');
            }else{
                $date1 = new DateTime($request->getQueryParams('')['dateInitial']);
            }

            if(!isset($request->getQueryParams('')['dateFinal'])){
                $date2 = new DateTime();
            }else if(empty($request->getQueryParams('')['dateFinal'])){
                $date2 = new DateTime();
            }else{
                $date2 = new DateTime($request->getQueryParams('')['dateFinal']);
            }

            $date1 = $date1->format(DateTime::ISO8601);
            $date2 = $date2->format(DateTime::ISO8601);

            if(strtotime($date1) > strtotime($date2)){
                $initial = $date2;
                $final = $date1;
            }else if(strtotime($date1) < strtotime($date2)){
                $initial = $date1;
                $final = $date2;
            }else{
                throw new Exception("Datas iguais");
            }

            $transacaoDAO = new TransacaoDAO();

            $res = $transacaoDAO->getAllByConta(
                $idConta,
                $initial,
                $final
            );

            $response->getBody()->write(
                json_encode(
                    $res,
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
}
