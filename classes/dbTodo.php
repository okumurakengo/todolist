<?php

class dbTodo extends DB {

    private $id;
    private $category_id;
    private $category_title;
    private $content;
    private $check_flg;
    private $createdate;
    private $modifieddate;
    private $todoList;

    // getter
    public function getId(){
        return $this->id;
    }

    public function getCategory_id(){
        return $this->category_id;
    }

    public function getCategory_title(){
        return $this->category_title;
    }

    public function getContent(){
        return $this->content;
    }

    public function getCheck_flg(){
        return $this->check_flg;
    }

    public function getCreatedate(string $format = 'Y年m月d日 H:i'){
        return (new DateTime($this->createdate))->format($format);
    }

    public function getModifieddate(string $format = 'Y年m月d日 H:i'){
        return $this->modifieddate ? (new DateTime($this->modifieddate))->format($format) : null;
    }

    // setter
    public function setCategory_id(int $category_id){
        $this->category_id = $category_id;
    }
    
    public function setContent(string $content){
        $this->content = $content;
    }
    
    public function setCheck_flg(bool $check_flg){
        $this->check_flg = $check_flg;
    }
    
    // 共通
    private function saveTodo(array $data){
        $this->id             = $data['id'];
        $this->category_id    = $data['category_id'];
        $this->category_title = $data['category_title'] ?? null;
        $this->content        = $data['content'];
        $this->check_flg      = $data['check_flg'];
        $this->createdate     = $data['createdate'];
        $this->modifieddate   = $data['modifieddate'];
    }

    public function getTodo(int $id){
        $stmt = $this->pdo->prepare("select * from todo where id=:id");
        $stmt->execute(['id' => $id]);
        $this->saveTodo($stmt->fetch());
    }

    public function getTodoList(){
        $this->todoList = $this->pdo->query("select todo.*,
                                                    category.title category_title
                                             from todo 
                                             left join category on todo.category_id=category.id
                                             order by todo.createdate desc");
    }

    public function getTodoListData(){
        $res = $this->todoList->fetch();
        $res ? $this->saveTodo($res) : false;
        return $res;
    }

    public function addTodo(array $data){
        $stmt = $this->pdo->prepare("insert into
                                     todo('category_id','content','check_flg','createdate')
                                     values(:category_id,:content,:check_flg,datetime('now','localtime'))");
        $stmt->execute([
            'category_id' => $data['category_id'],
            'content'     => $data['content'],
            'check_flg'   => $data['check_flg'] ?? 0,
        ]);
    }

    public function updateTodo(){
        $stmt = $this->pdo->prepare("update todo 
                                     set category_id=:category_id,
                                         content=:content,
                                         check_flg=:check_flg,
                                         modifieddate=datetime('now','localtime') 
                                     where id=:id");
        $stmt->execute([
            'id'=>$this->id,
            'category_id'=>$this->category_id,
            'content'=>$this->content,
            'check_flg'=>$this->check_flg ?? 0,
        ]);
    }

    public function delTodo(int $id){
        $stmt = $this->pdo->prepare("delete from todo where id=:id");
        $stmt->execute(['id' => $id]);
    }

    public function cntTodo(){
        return $this->pdo->query("select count(*) from todo")->fetch();
    }

}
