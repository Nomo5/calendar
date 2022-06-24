<?php

require_once './dbconnect.php';

$result = deleteTodo($_GET['id']);  //スケジュールの削除

echo $result;

?>