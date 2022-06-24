<?php

require_once './classes/calendar.php';

//カレンダー生成
if (isset($_GET['y']) && isset($_GET['m'])) {
    $cal = new Calendar($_GET['y'], $_GET['m']);
} else {
    $cal = new Calendar(date("Y"), date("n"));
}

$rows = $cal->create_rows();    //カレンダー配列の生成
$rows_count = count($rows) - 1; //最後の週

$year = $cal->get_year();
$month = $cal->get_month();

$first_day_of_week = $cal->get_first_day_of_week();     //月始めの曜日
$last_day_of_week = $cal->get_last_day_of_week();       //月終わりの曜日
$last_month_date = $cal->get_last_month_date();         //先月の最終日付
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <script src="./main.js"></script>
    <title>Calendar</title>
</head>

<body>
    <div class="wrapper">
        <header>
            <h1 id="y-m"><?php echo $year . '-' . $month ?></h1>
            <a href="?y=<?php echo $year ?>&m=<?php echo ($month - 1) ?>" class="btn_item" id="prev">prev</a>
            <a href="?y=<?php echo $year ?>&m=<?php echo ($month + 1) ?>" class="btn_item" id="next">next</a>
        </header>
        <div class="content">
            <!-- カレンダー部分 -->
            <div class="calendar">
                <table>
                    <tr>
                        <th>Sun</th>
                        <th>Mon</th>
                        <th>Tue</th>
                        <th>Wed</th>
                        <th>Thr</th>
                        <th>Fri</th>
                        <th>Sat</th>
                    </tr>
                    <?php foreach ($rows as $index => $row) : ?>
                        <tr>
                            <?php for ($i = 0; $i <= 6; $i++) : ?>
                                <?php if ($index === 0 && $i < $first_day_of_week) : ?>
                                    <td class="disabled"><?php echo ($last_month_date - $first_day_of_week + $i + 1) ?></td>
                                <?php elseif ($index === $rows_count && $i > $last_day_of_week) : ?>
                                    <td class="disabled"><?php echo ($i - $last_day_of_week) ?></td>
                                <?php else : ?>
                                    <td onclick="open_todos(<?php echo $year ?>, <?php echo $month ?>, <?php echo $row[$i] ?>)"><?php echo $row[$i] ?></td>
                                <?php endif ?>
                            <?php endfor ?>
                        </tr>
                    <?php endforeach ?>
                </table>
            </div>

            <!-- スケジュール表示部分 -->
            <div id="box">
                <div>
                    <p id="close" onclick="hiddenBox()">x</p>
                    <h3 class="schedule">今日の予定</h3>
                    <div id="form_todo">
                        <input type="text" id="newtodo" placeholder="予定を追加">
                        <button type="button" id="delete" onclick="addTodo()">+</button>
                    </div>
                </div>
                <div id="todo_list">
                    <ul id="todolist1"></ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>