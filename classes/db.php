<?php

class DB {
    protected $pdo;

    public function __construct() {
        if(!is_dir(__DIR__.'/../db')) mkdir(__DIR__.'/../db');
        $pdo = new PDO('sqlite:'.__DIR__.'/../db/db.sqlite');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->pdo = $pdo;
    }

    public function createtodo(){
        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS todo(
                id           INTEGER PRIMARY KEY AUTOINCREMENT,
                category_id  INTEGER,
                content      VARCHAR(300),
                check_flg    INTEGER,
                createdate   DATETIME,
                modifieddate DATETIME
            )"
        );
        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS category(
                id           INTEGER PRIMARY KEY AUTOINCREMENT,
                title        VARCHAR(50),
                createdate   DATETIME,
                modifieddate DATETIME
            )"
        );
        $this->pdo->exec(
            "INSERT INTO category(
                title,
                createdate
             )
             SELECT title,createdate FROM (
                SELECT 'MyWork'                    title,
                       DATETIME('now','localtime') createdate
                UNION ALL
                SELECT 'Todos'                     title,
                       DATETIME('now','localtime') createdate
                UNION ALL
                SELECT 'Shopping'                  title,
                       DATETIME('now','localtime') createdate
             )
             JOIN
             (SELECT COUNT(*) count FROM category)
             WHERE count = 0"
        );
    }
}
