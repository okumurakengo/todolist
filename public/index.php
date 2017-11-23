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
    $view = new \Slim\Views\Twig(__DIR__.'/../templates', [
        'cache' => __DIR__.'/../cache',
        'debug' => true
    ]);

    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));
    return $view;
};

$app->get('/', function (Request $request, Response $response) {
    $db = new DB();
    $db->createtodo();
    return $response->withStatus(302)->withHeader('Location', '/todos');
});

require_once __DIR__ . '/todos.php';
require_once __DIR__ . '/category.php';

$app->run();
