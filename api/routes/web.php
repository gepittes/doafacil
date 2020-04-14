<?php

$router->get('/', function () use ($router) {
    return redirect()->route('api');
});

define('API_VERSION', '1.0');
$apiPattern = 'v1';

$router->group(['prefix' => $apiPattern], function () use ($router) {

    $router->post('/autenticacao/login', 'AutenticacaoController@post');

    $router->group(['namespace' => 'Instituicao'], function () use ($router) {
        $router->get('/instituicoes', 'InstituicaoController@get');
        $router->get('/instituicoes/{id}', 'InstituicaoController@get');
        $router->post('/instituicoes', 'InstituicaoController@post');
        $router->patch('/instituicoes/{id}', 'InstituicaoController@patch');
        $router->delete('/instituicoes/{id}', 'InstituicaoController@delete');

        $router->get('/user/{id}/instituicoes', 'InstituicaoController@getInstisUser');
    });

    $router->group(['namespace' => 'Evento'], function () use ($router) {
        $router->get('/eventos', 'EventoController@get');
        $router->get('/eventos/{id}', 'EventoController@get');
        $router->post('/eventos', 'EventoController@post');
        $router->patch('/eventos/{id}', 'EventoController@patch');
        $router->delete('/eventos/{id}', 'EventoController@delete');

        $router->get('/instituicoes/{id}/eventos', 'EventoController@getEventosByInsti');
    });

    $router->group(['namespace' => 'Ponto'], function () use ($router) {
        $router->get('/pontos', 'PontoController@get');
        $router->post('/pontos', 'PontoController@post');
        $router->patch('/pontos/{id}', 'PontoController@patch');
        $router->delete('/pontos/{id}', 'PontoController@delete');

        $router->get('/instituicoes/{id}/pontos', 'PontoController@getPontosByInst');
    });

    $router->group(['namespace' => 'Conta'], function () use ($router) {
        $router->post('/conta', 'ContaController@post');
        $router->get('/conta[/{id}]', 'ContaController@get');
        $router->patch('/conta[/{id}]', 'ContaController@patch');
        $router->delete('/conta[/{id}]', 'ContaController@delete');
    });

    $router->group(['namespace' => 'Image'], function () use ($router) {
        $router->post('/image', 'ImageController@post');
    });

    $router->group(['namespace' => 'Item'], function () use ($router) {
        $router->get('/itens', 'ItemController@get');
        $router->get('/itens/{id}', 'ItemController@get');
        $router->post('/itens', 'ItemController@post');
        $router->patch('/itens/{id}', 'ItemController@patch');
        $router->delete('/itens/{id}', 'ItemController@delete');

        $router->get('/instituicoes/{id}/itens', 'ItemController@getItensByInsti');
    });

    $router->group(['middleware' => 'jwt.auth'], function () use ($router) {
    });
});
// 
