<?php

class dbTodos extends DB {

    private $id;
    private $title;
    private $createdate;
    private $modifieddate;
    private $todolist;

    public function getLIstTods(){
        $todolist = $this->pdo->query("SELECT * FROM todolist ORDER BY id");
    }
}
