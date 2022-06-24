<?php
require_once './dbconnect.php';

$todos = getTodos($_GET['ymd']);    //その日付に登録された全スケジュールを取得

$json = json_encode($todos, JSON_UNESCAPED_UNICODE);

echo $json;

?>