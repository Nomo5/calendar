<?php 
require_once './dbconnect.php';

$result = addTodo($_POST['newtodo'], $_POST['ymd']);


echo $result;

?>