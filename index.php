<!doctype html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Calendar</title>
    <link rel="stylesheet" href="./css/style.css" type="text/css">
    <link rel="stylesheet" href="./css/index.css" type="text/css">
</head>
<body>
<?php
date_default_timezone_set('PRC');//设置时区

if (empty($_POST)) {
    $date = date('Y-m');//当前的年月
    file_put_contents('./data.txt', 0);
} else {
    changeMonth($_POST['date']); //根据递归值变更月份
    $contents = file_get_contents('./data.txt');
    $date = date('Y-m', strtotime($contents . " month"));
}

function simCalender($date)
{
    global $contents;
    // $wStart => 当月是从星期几开始的(0-6)
    for ($i = 0, $wStart = date('w', strtotime($date . '-01')); $i < $wStart; $i++) {
        echo "<li></li>";
    }
    // $sum => 当月共有多少天
    for ($i = 1, $sum = date('t', strtotime($contents . " month")); $i <= $sum; $i++) {
        echo "<li>{$i}</li>";
    }
}

function changeMonth($i)
{
    if ($i === "now") {
        file_put_contents('./data.txt', 0);
        return;
    }
    $new = $i + file_get_contents('./data.txt');
    file_put_contents('./data.txt', $new);
}

?>
<div class="wrapper center">
    <h4><?= $date ?></h4>
    <form action="./index.php" method="post">
        <button type="submit" name="date" value="-12">Last Year</button>
        <button type="submit" name="date" value="-1">Last Month</button>
        <button type="submit" name="date" value="now">now</button>
        <button type="submit" name="date" value="1">Next Month</button>
        <button type="submit" name="date" value="12">Next Year</button>
    </form>
    <ul class="list" id="week">
        <li>Sun</li>
        <li>Mon</li>
        <li>Tus</li>
        <li>Wed</li>
        <li>Thu</li>
        <li>Fri</li>
        <li>Sat</li>
    </ul>
    <ol class="list" id="days">
        <?php
        simCalender($date);
        ?>
    </ol>
</div>
</body>
</html>