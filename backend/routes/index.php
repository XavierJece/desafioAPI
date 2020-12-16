<?php

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

use function src\{
    slimConfiguration
};

use App\Controllers\{
    PostController,
    AuthController,
    CommentController,
    UserController
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

$app->post('/login', AuthController::class . ':login');
$app->post('/users', UserController::class . ':create');


$app->get('/posts', PostController::class . ':index');
$app->get('/posts/{postId}', PostController::class . ':show');

// =========================================

$app->run();
