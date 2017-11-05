<?php

class DB {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createtodo(){
        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS todolist(
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                category_id INTEGER,
                todo VARCHAR(300),
                createdate DATETIME,
                modifieddate DATETIME
            )"
        );
        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS category(
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title VARCHAR(50),
                createdate DATETIME,
                modifieddate DATETIME
            )"
        );
        $this->pdo->exec(
            "INSERT INTO category(
                title,
                createdate,
                modifieddate
             )
             SELECT title,createdate,modifieddate FROM (
                SELECT 'MyWork'                    title,
                       DATETIME('now','localtime') createdate,
                       DATETIME('now','localtime') modifieddate
                UNION ALL
                SELECT 'Todos'                     title,
                       DATETIME('now','localtime') createdate,
                       DATETIME('now','localtime') modifieddate
                UNION ALL
                SELECT 'Shopping'                  title,
                       DATETIME('now','localtime') createdate,
                       DATETIME('now','localtime') modifieddate
             )
             JOIN
             (SELECT COUNT(*) count FROM category)
             WHERE count = 0"
        );
    }
}
