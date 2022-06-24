<?php 

require_once './env.php';

/**
 * データベース接続
 * 
 * @param void
 * @return PDO $dbh
 */
function dbConnect() {
    $host = DB_HOST;
    $db   = DB_NAME;
    $user = DB_USER;
    $pass = DB_PASS;

    $dsn = "mysql:host=$host; dbname=$db; charset=utf8";

    try {
        $dbh = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
        // echo '接続成功';
    } catch (PDOException $e) {
        echo '接続失敗' . $e->getMessage();
        exit();
    }

    return $dbh;
    
}

/**
 * その日の予定を抽出
 * 
 * @param string $date
 * @return array $result
 */
function getTodos($date) {

    if ( empty($date) ) {
        exit('日付が不正です。');
    }

    $dbh = dbConnect();

    $stmt = $dbh->prepare('SELECT * FROM todos WHERE todo_date = :todo_date');
    $stmt->bindValue(':todo_date', $date, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

/**
 * 指定した予定の削除
 * 
 * @param integer $id
 * @return bool   $result
 */
function deleteTodo($id) {

    $result = false;
     if ( empty($id) ) {
        exit();
     }

     $sql = 'DELETE FROM todos WHERE id = :id';
     $dbh = dbConnect();
     $dbh->beginTransaction();
     try {
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();
        $dbh->commit();
        echo '予定を削除しました。';
     } catch (PDOException $e) {
        $dbh->rollBack();
        echo $e->getMessage();
        return $result;
     }
     return $result = true;
}

/**
 * 予定を追加
 * 
 * @param string $newtodo
 * @param string $date
 * 
 * @return bool 
 */
function addTodo($newtodo, $date) {

    $sql = 'INSERT INTO
                todos(todo_text, todo_date)
            VALUES
                (:todo_text, :todo_date)';
    
    $dbh = dbConnect();

    $dbh->beginTransaction();
    try {
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':todo_text', $newtodo, PDO::PARAM_STR);
        $stmt->bindValue(':todo_date', $date, PDO::PARAM_STR);

        $stmt->execute();
        $dbh->commit();
        echo '予定を追加しました。';
        return true;
    } catch (PDOException $e) {
        $dbh->rollBack();
        exit($e);
    }
}

?>