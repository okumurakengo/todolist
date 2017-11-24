<?php

class dbCategory extends DB {
    
    private $id;
    private $title;
    private $createdate;
    private $modifieddate;
    private $categoryList;

    // getter
    public function getId(){
        return $this->id;
    }

    public function getTitle(){
        return $this->title;
    }

    public function getCreatedate(string $format = 'Y年m月d日 H:i'){
        return (new DateTime($this->createdate))->format($format);
    }

    public function getModifieddate(string $format = 'Y年m月d日 H:i'){
        return $this->modifieddate ? (new DateTime($this->modifieddate))->format($format) : null;
    }

    // setter
    public function setTitle(string $title){
        $this->title = $title;
    }

    // 共通
    private function saveCategory(array $data){
        $this->id           = $data['id'];
        $this->title        = $data['title'];
        $this->createdate   = $data['createdate'];
        $this->modifieddate = $data['modifieddate'];
    }

    public function getCategory(int $id){
        $stmt = $this->pdo->prepare("select * from category where id=:id");
        $stmt->execute(['id' => $id]);
        $this->saveCategory($stmt->fetch());
    }

    public function getCategoryList(){
        $this->categoryList = $this->pdo->query("select * from category order by id");
    }

    public function getCategoryListData(){
        $res = $this->categoryList->fetch();
        $res ? $this->saveCategory($res) : false;
        return $res;
    }

    public function addCategory(array $data){
        $stmt = $this->pdo->prepare("insert into
                                     category('title','createdate')
                                     values  (:title,datetime('now','localtime'))");
        $stmt->execute(['title'=>$data['title']]);
    }

    public function updateCategory(){
        $stmt = $this->pdo->prepare("update category 
                                     set title=:title,
                                     modifieddate=datetime('now','localtime') 
                                     where id=:id");
        $stmt->execute([
            'id'=>$this->id,
            'title'=>$this->title
        ]);
    }

    public function delCategory(int $id){
        $stmt = $this->pdo->prepare("delete from category where id=:id");
        $stmt->execute(['id' => $id]);
    }

    public function cntCategory(){
        return $this->pdo->query("select count(*) cnt from category")->fetch()['cnt'];
    }

}
