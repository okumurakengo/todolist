<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app->get('/category', function (Request $request, Response $response) {
    $dbCategory = new dbCategory;
    $dbCategory->getCategoryList();
    while($dbCategory->getCategoryListData()){
        $categoryList[] = [
            'id'           => $dbCategory->getId(),
            'title'        => $dbCategory->getTitle(),
            'createdate'   => $dbCategory->getCreatedate(),
            'modifieddate' => $dbCategory->getModifieddate(),
        ];
    }
 
    return $this->view->render($response,"category.html.twig",compact('categoryList'));
});

$app->get('/category/add', function (Request $request, Response $response) {
    return $this->view->render($response,"categoryform.html.twig");
});

$app->post('/category/add', function (Request $request, Response $response) {
    $dbCategory = new dbCategory;
    $dbCategory->addCategory($request->getParsedBody());
    return $response->withStatus(302)->withHeader('Location', '/category');
});

$app->get('/category/edit/{id}', function (Request $request, Response $response, $args) {
    $dbCategory = new dbCategory;
    $dbCategory->getCategory($args['id']);
    $categoryData = [
        'id'           => $dbCategory->getId(),
        'title'        => $dbCategory->getTitle(),
        'createdate'   => $dbCategory->getCreatedate('Y-m-d H:i:s'),
        'modifieddate' => $dbCategory->getModifieddate('Y-m-d H:i:s'),
    ];
    
    return $this->view->render($response,"categoryform.html.twig",compact('categoryData'));
});

$app->post('/category/edit/{id}', function (Request $request, Response $response, $args) {
    $dbCategory = new dbCategory;
    $dbCategory->getCategory($args['id']);
    $dbCategory->setTitle($request->getParsedBody()['title']);
    $dbCategory->updateCategory();
    return $response->withStatus(302)->withHeader('Location', '/category');
});

$app->post('/category/del/{id}', function (Request $request, Response $response, $args) {
    $dbCategory = new dbCategory;
    $dbTodo = new dbTodo;

    if($categoryCnt=($dbCategory->cntCategory()==='1')){
        $massage = 'カテゴリーデータが1件の場合は削除できません。';
    }
    if($todoCnt=$dbTodo->cntTodo($args['id'])){
        $massage = 'todoにデータがある場合は削除できません。';
    }
    if($categoryCnt||$todoCnt){
        return "<html><body>
                    <script>alert('${massage}');
                            location.href='/category';</script>
                </body></html>";
    }

    $dbCategory->delCategory($args['id']);
    return $response->withStatus(302)->withHeader('Location', '/category');
});
