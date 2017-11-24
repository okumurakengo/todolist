<?php
// ルーティング設定
if(preg_match('/\.css$/i',$_SERVER["REQUEST_URI"])) {
    header('Content-Type: text/css; charset=utf-8');
    require __DIR__.'/css/'.basename($_SERVER['PHP_SELF']);
} elseif(preg_match('/\.js$/i',$_SERVER["REQUEST_URI"])){
    header('Content-Type: text/javascript; charset=utf-8');
    require __DIR__.'/js/'.basename($_SERVER['PHP_SELF']);
} else {
    require __DIR__."/index.php";
}
