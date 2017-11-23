<?php
// ルーティング設定
if(preg_match('/\.css$/i',$_SERVER["REQUEST_URI"])) {
    header('Content-Type: text/css; charset=utf-8');
    require __DIR__.$_SERVER["REQUEST_URI"];
} elseif(preg_match('/\.js$/i',$_SERVER["REQUEST_URI"])){
    header('Content-Type: text/javascript; charset=utf-8');
    require __DIR__.$_SERVER["REQUEST_URI"];
} elseif(file_exists(__DIR__.$_SERVER["REQUEST_URI"]) && is_file(__DIR__.$_SERVER["REQUEST_URI"])){
    require __DIR__.$_SERVER["REQUEST_URI"];
} else {
    require __DIR__."/public/index.php";
}
