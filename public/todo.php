<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/todo', function (Request $request, Response $response) {
    $dbTodo = new dbTodo;
    $dbTodo->getTodoList();
    while($dbTodo->getTodoListData()){
        $todoList[] = [
            'id'             => $dbTodo->getId(),
            'category_id'    => $dbTodo->getCategory_id(),
            'category_title' => $dbTodo->getCategory_title(),
            'content'        => $dbTodo->getContent(),
            'check_flg'      => $dbTodo->getCheck_flg(),
            'createdate'     => $dbTodo->getCreatedate(),
            'modifieddate'   => $dbTodo->getModifieddate(),
        ];
    }
 
    return $this->view->render($response,"todo.html.twig",compact('todoList'));
});

$app->get('/todo/add', function (Request $request, Response $response) {
    $dbCategory = new dbCategory;
    $dbCategory->getCategoryList();
    while($dbCategory->getCategoryListData()){
        $categoryList[] = [
            'id'    => $dbCategory->getId(),
            'title' => $dbCategory->getTitle(),
        ];
    }

    return $this->view->render($response,"todoform.html.twig",compact('categoryList'));
});

$app->post('/todo/add', function (Request $request, Response $response) {
    $dbTodo = new dbTodo;
    $dbTodo->addTodo($request->getParsedBody());
    return $response->withStatus(302)->withHeader('Location', '/todo');
});

$app->get('/todo/edit/{id}', function (Request $request, Response $response, $args) {
    $dbCategory = new dbCategory;
    $dbTodo = new dbTodo;
    $dbCategory->getCategoryList();

    while($dbCategory->getCategoryListData()){
        $categoryList[] = [
            'id'    => $dbCategory->getId(),
            'title' => $dbCategory->getTitle(),
        ];
    }

    $dbTodo->getTodo($args['id']);
    $todoData = [
        'id'             => $dbTodo->getId(),
        'category_id'    => $dbTodo->getCategory_id(),
        'content'        => $dbTodo->getContent(),
        'check_flg'      => $dbTodo->getCheck_flg(),
        'createdate'     => $dbTodo->getCreatedate(),
        'modifieddate'   => $dbTodo->getModifieddate(),
    ];
    
    return $this->view->render($response,"todoform.html.twig",compact('categoryList','todoData'));
});

$app->post('/todo/edit/{id}', function (Request $request, Response $response, $args) {
    $dbTodo = new dbTodo;
    $dbTodo->getTodo($args['id']);
    $dbTodo->setCategory_id($request->getParsedBody()['category_id']);
    $dbTodo->setContent($request->getParsedBody()['content']);
    $dbTodo->setCheck_flg((bool)$request->getParsedBody()['check_flg']);
    $dbTodo->updateTodo();
    return $response->withStatus(302)->withHeader('Location', '/todo');
});

$app->post('/todo/update/{id}', function (Request $request, Response $response, $args) {
    $dbTodo = new dbTodo;
    $dbTodo->getTodo($args['id']);
    $dbTodo->setCheck_flg(!$dbTodo->getCheck_flg());
    $dbTodo->updateTodo();
    return $response->withStatus(302)->withHeader('Location', '/todo');
});

$app->post('/todo/del/{id}', function (Request $request, Response $response, $args) {
    $dbTodo = new dbTodo;
    $dbTodo->delTodo($args['id']);
    return $response->withStatus(302)->withHeader('Location', '/todo');
});
