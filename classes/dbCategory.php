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

    public function getCreatedate(){
        return $this->createdate;
    }

    public function getModifieddate(){
        return $this->modifieddate;
    }

    // setter
    public function setTitle(string $title){
        $this->title = $title;
    }

    // 共通
    private function saveCategory(array $data){
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->createdate = $data['createdate'];
        $this->modifieddate = $data['modifieddate'];
    }

    public function getCategory(int $id){
        $stmt = $this->pdo->prepare("select * from category where id=:id");
        $stmt->execute(['id' => $id]);
        $this->saveCategory($stmt->fetch());
    }

    public function getCategoryList(){
        $this->categoryList = $this->pdo
                                ->query("select * from category order by id")
                                ->fetAll();
    }

    public function UpdateCategory(){
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
        $stmt->execute(['id' => $id,]);
    }

}
