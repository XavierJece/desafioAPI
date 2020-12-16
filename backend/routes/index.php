<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use function src\{
    slimConfiguration
};

use App\Controllers\{
    AtivarContaController,
    ContaController,
    DepositoController,
    DesativarContaController,
    SaqueController,
    TransacaoController
};

$app = new \Slim\App(slimConfiguration());

// =========================================

$app->get('/', function (Request $request, Response $response) {
    $message = [
        'status' => 200,
        'message' => 'Hello Word!',
    ];

    $response->getBody()->write(
        json_encode(
            $message,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        )
    );

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->post('/conta', ContaController::class . ':create');
$app->get('/conta/{idConta}', ContaController::class . ':show');

$app->get('/conta/{idConta}/transacoes', TransacaoController::class . ':index');
$app->post('/conta/{idConta}/saque', SaqueController::class . ':create');
$app->post('/conta/{idConta}/deposito', DepositoController::class . ':create');

$app->patch('/conta/{idConta}/ativar', AtivarContaController::class . ':update');
$app->patch('/conta/{idConta}/desativar', DesativarContaController::class . ':update');


// =========================================

$app->run();
