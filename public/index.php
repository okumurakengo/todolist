<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__ . '/../vendor/autoload.php';

$config = [
    'determineRouteBeforeAppMiddleware' => true,
    'displayErrorDetails' => true,
    'addContentLengthHeader' => false,
];

$app = new \Slim\App(["settings" => $config]);
$container = $app->getContainer();

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('templates', [
        'cache' => 'cache',
        'debug' => true
    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    return $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
};

$app->get('/', function (Request $request, Response $response) {
    $db = new DB();
    $db->createtodo();
    return $response->withStatus(302)->withHeader('Location', '/todos');
});

require_once __DIR__ . '/todos.php';

$app->run();
