# myCalendar
This is my calendar that can quickly query the date.  But it's just an exercise.

**<http://zoushicheng.com/calendar/>**

## buttons
实现思路是按钮组发送表单事件至 index.php 本身，月份的更改用 value 值来计算

    <form action="./index.php" method="post">
        <button type="submit" name="date" value="-12">Last Year</button>
        <button type="submit" name="date" value="-1">Last Month</button>
        <button type="submit" name="date" value="now">now</button>
        <button type="submit" name="date" value="1">Next Month</button>
        <button type="submit" name="date" value="12">Next Year</button>
    </form>
    
## $_POST的值验证
我们既然用"POST"提交表单信息，必然需要接受。这里需要作一个验证，其实这很类似于递归不是吗？

    if (empty($_POST)) {
        $date = date('Y-m');//当前的年月
        file_put_contents('./data.txt', 0);//用户刚刚进入本页面，我们将记录月份的值初始化
    } else {
        changeMonth($_POST['date']); //根据递归值变更月份
        $contents = file_get_contents('./data.txt');
        $date = date('Y-m', strtotime($contents . " month"));
    }
    
## 如何去制作每一个 li ？
当然，这里也可以去用表格去实现，大同小异。
我们需要构建一个足够方便的函数，传入如"2017-12"这种参数即可生效。

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
    
## 使用 simCalender ！
    
    <ol class="list" id="days">
        <?php
        simCalender($date);
        ?>
    </ol>