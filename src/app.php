<?php

require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$usuarios = [
    [
        "id" => 1,
        "nome" => "João Silva",
        "email" => "joao@email.com",
        "senha" => "123456"
    ],
    [
        "id" => 2,
        "nome" => "Maria Souza",
        "email" => "maria@email.com",
        "senha" => "123456"
    ],
    [
        "id" => 3,
        "nome" => "Pedro Santos",
        "email" => "pedro@email.com",
        "senha" => "123456"
    ],
    [
        "id" => 4,
        "nome" => "Ana Oliveira",
        "email" => "ana@email.com",
        "senha" => "123456"
    ],
    [
        "id" => 5,
        "nome" => "Carlos Lima",
        "email" => "carlos@email.com",
        "senha" => "123456"
    ]
];

$app->get('/status', function ($request, $response) {

    $dados = [
        "status" => "API funcionando"
    ];

    $response->getBody()->write(
        json_encode($dados)
    );

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->get('/usuarios', function ($request, $response) use (&$usuarios) {

    $response->getBody()->write(
        json_encode($usuarios)
    );

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(200);
});

$app->get('/usuarios/{id}', function ($request, $response, $args) use (&$usuarios) {

    $id = (int) $args['id'];

    foreach ($usuarios as $usuario) {
        if ($usuario['id'] === $id) {

            $response->getBody()->write(
                json_encode($usuario)
            );

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }
    }

    $resposta = [
        "erro" => "Usuário não encontrado"
    ];

    $response->getBody()->write(
        json_encode($resposta)
    );

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(404);
});

$app->post('/usuarios', function ($request, $response) use (&$usuarios) {

    $dados = $request->getParsedBody();

    $novoId = count($usuarios) + 1;

    $novoUsuario = [
        "id" => $novoId,
        "nome" => $dados['nome'],
        "email" => $dados['email'],
        "senha" => $dados['senha']
    ];

    $usuarios[] = $novoUsuario;

    $response->getBody()->write(
        json_encode($novoUsuario)
    );

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(201);
});

$app->put('/usuarios/{id}', function ($request, $response, $args) use (&$usuarios) {

    $id = (int) $args['id'];
    $dados = $request->getParsedBody();

    foreach ($usuarios as &$usuario) {
        if ($usuario['id'] === $id) {

            $usuario['nome'] = $dados['nome'];
            $usuario['email'] = $dados['email'];
            $usuario['senha'] = $dados['senha'];

            $response->getBody()->write(
                json_encode($usuario)
            );

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }
    }

    $resposta = [
        "erro" => "Usuário não encontrado"
    ];

    $response->getBody()->write(
        json_encode($resposta)
    );

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(404);
});

$app->delete('/usuarios/{id}', function ($request, $response, $args) use (&$usuarios) {

    $id = (int) $args['id'];

    foreach ($usuarios as $indice => $usuario) {
        if ($usuario['id'] === $id) {

            unset($usuarios[$indice]);

            $usuarios = array_values($usuarios);

            $resposta = [
                "mensagem" => "Usuário excluído com sucesso"
            ];

            $response->getBody()->write(
                json_encode($resposta)
            );

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }
    }

    $resposta = [
        "erro" => "Usuário não encontrado"
    ];

    $response->getBody()->write(
        json_encode($resposta)
    );

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(404);
});

$app->post('/login', function ($request, $response) use (&$usuarios) {

    $dados = $request->getParsedBody();

    foreach ($usuarios as $usuario) {
        if (
            $usuario['email'] === $dados['email'] &&
            $usuario['senha'] === $dados['senha']
        ) {

            $resposta = [
                "mensagem" => "Login realizado com sucesso",
                "usuario" => [
                    "id" => $usuario['id'],
                    "nome" => $usuario['nome'],
                    "email" => $usuario['email']
                ]
            ];

            $response->getBody()->write(
                json_encode($resposta)
            );

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }
    }

    $resposta = [
        "erro" => "Email ou senha inválidos"
    ];

    $response->getBody()->write(
        json_encode($resposta)
    );

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(401);
});

$app->put('/usuarios/{id}/senha', function ($request, $response, $args) use (&$usuarios) {

    $id = (int) $args['id'];
    $dados = $request->getParsedBody();

    foreach ($usuarios as &$usuario) {
        if ($usuario['id'] === $id) {

            $usuario['senha'] = $dados['senha'];

            $resposta = [
                "mensagem" => "Senha alterada com sucesso"
            ];

            $response->getBody()->write(
                json_encode($resposta)
            );

            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(200);
        }
    }

    $resposta = [
        "erro" => "Usuário não encontrado"
    ];

    $response->getBody()->write(
        json_encode($resposta)
    );

    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(404);
});