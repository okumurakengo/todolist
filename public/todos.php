<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/todos', function (Request $request, Response $response) {
    
});

$app->get('/todos/add', function (Request $request, Response $response) {
    
});

$app->post('/todos/add', function (Request $request, Response $response) {

});

$app->get('/todos/edit/{id}', function (Request $request, Response $response, $args) {
    
});

$app->post('/todos/edit', function (Request $request, Response $response) {
    
});

$app->post('/todos/del/{id}', function (Request $request, Response $response, $args) {

});
