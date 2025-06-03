<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>線上月曆</title>
    <style>
        h1 {
            text-align: center;
            color: blue;
        }

        table {
            width: 60%;
            border-collapse: collapse;
            margin: 0 auto;
            /* 只有在設定寬度後才有效，讓表格置中 */
        }

        td {
            border: 1px solid black;
            text-align: center;
            padding: 5px 10px;
            /* 垂直5px、水平10px 的內距 */
        }

        /* 今日的樣式 */
        .today {
            background-color: lightblue;
            font-weight: bold;
            color: white;
        }

        /* 其他月份的日期樣式 */
        .other-month {
            background-color: gray;
            font-size: 10px;
            color: #aaa;
            /* 淡色文字 */
        }

        /* 週末（假日）樣式 */
        .holiday {
            background-color: pink;
            color: white;
        }

        /* 滑鼠移到格子上時的效果（不套在第一列） */
        tr:not(tr:nth-child(1)) td:hover {
            background-color: lightseagreen;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        /* 過去的日期樣式（可搭配 today / holiday / other-month 同時出現） */
        .pass-date {
            /* background-color: lightgray; */
            /* 如果你想淡化背景可以打開 */
            color: #aaa;
            /* 文字變淡 */
        }

        .date-num {
            font-size: 14px;
            text-align: left;
        }

        .date-event {
            height: 40px;
            width: 80px;
            text-align: center;
            line-height: 40px;

        }

        .box,
        .th-box {
            width: 60px;
            height: 50px;
            background-color: lightblue;
            display: inline-block;
            border: 1px solid blue;
            box-sizing: border-box;
            margin-left: -1px;
            margin-top: -1px;
            vertical-align: top;
            /* vertical解決baseline造成的問題 */
        }

        .box-container {
            width: 420px;
            margin: 0 auto;
            box-sizing: border-box;
            padding-left: 1px;
            padding-top: 1px;
        }

        .th-box {
            height: 25px;
            text-align: center;
        }

        .day-num,
        .day-week {
            display: inline-block;
            width: 50%;
        }

        .day-num {
            color: #999;
            font-size: 14px;
        }

        .day-week {
            color: #aaa;
            font-size: 12px;
            text-align: right;
        }
    </style>

</head>

<body>

    <!-- <div class="box-container">
    <?php

    //  for($i=0;$i<20;$i++){
    //     echo "<div class='box'>";
    //         echo $i;
    //     echo "</div>";
    // } 
    // 
    ?>
    </div> -->


    <h1>線上日曆</h1>

    <?php
    // 取得目前的月份，如果有傳入 $_GET['month'] 就使用，否則使用當前月份
    if (isset($_GET['month'])) {
        $month = $_GET['month'];
    } else {
        $month = date("m");
    }

    // 取得目前的年份，如果有傳入 $_GET['year'] 就使用，否則使用當前年份
    if (isset($_GET['year'])) {
        $year = $_GET['year'];
    } else {
        $year = date("Y");
    }

    // 計算上一個月與對應的年份
    if ($month - 1 > 0) {
        $prev = $month - 1;     // 上一個月
        $prevyear = $year;      // 年份不變
    } else {
        $prev = 12;             // 如果目前是 1 月，上一個月是 12 月
        $prevyear = $year - 1;  // 年份減 1
    }

    // 計算下一個月與對應的年份
    if ($month + 1 > 12) {
        $next = 1;              // 如果目前是 12 月，下一個月是 1 月
        $nextyear = $year + 1;  // 年份加 1
    } else {
        $next = $month + 1;     // 下一個月
        $nextyear = $year;      // 年份不變
    }
    //$month = 5;

    $today = date("Y-$month-d");
    $firstDay = date("Y-$month-01"); //文字模板  
    $firstDayWeek = date("w", strtotime($firstDay)); // w = 在這一週的哪一天
    $theDaysOfMonth = date("t", strtotime($firstDay));
    //變數用駝峰式命名法:小駝峰 theDaysOfMonth/大駝峰 TheDaysOfMonth
    //蛇型/鍊式命名法 the_days_of_month / the-days-of-month

    $spDate = [
        '2025-04-04' => '兒童節',
        '2025-04-05' => '清明節',
        '2025-05-01' => '勞動節',
        '2025-05-11' => '母親節',
        '2025-05-30' => '端午節',
        '2025-06-07' => '生日'
    ];

    $todoList = ['2025-05-09' => '開會'];

    $monthDays = [];

    //填入空白日期
    for ($i = 0; $i < $firstDayWeek; $i++) {
        $monthDays[] = [];
    }
    //填入當日日期
    for ($i = 0; $i < $theDaysOfMonth; $i++) {
        $timestamp = strtotime(" $i days", strtotime($firstDay));
        $date = date("d", $timestamp);
        $holiday = "";

        foreach ($spDate as $d => $value) {
            if ($d == date("Y-m-d", $timestamp)) {
                $holiday = $value;
            }
        }

        $todo = '';
        foreach ($todoList as $d => $value) {
            if ($d == date("Y-m-d", $timestamp)) {
                $todo = $value;
            }
        }

        $monthDays[] =
            [
                "day" => date("d", $timestamp),
                "fullDate" => date("Y-m-d", $timestamp),
                "weekOfYear" => date("W", $timestamp),
                "week" => date("w", $timestamp),
                "daysOfYear" => date("z", $timestamp),
                "workday" => date("N", $timestamp) < 6 ? true : false,
                "holiday" => $holiday, //在前面的foreach已經處理該變數
                "todo" => $todo
            ];
    }

    // echo "<pre>";
    // print_r($monthDays);
    // echo "</pre>";
    ?>

    <div style="display:flex;width:60%;margin:0 auto;justify-content:space-between;">

        <a href="?year=<?= $prevyear; ?>&month=<?= $prev; ?>">上一月</a>
        <a href="?year=<?= $nextyear; ?>&month=<?= $next; ?>">下一月</a>
    </div>

    <h2><?= $year; ?>年<?= $month; ?>月</h2>
    <h2 style='text-align:center;'><?= date("Y 年 m 月"); ?></h2>

    <?php


    //建立外框及標題
    echo "<div class='box-container'>";

    echo "<div class='th-box'>日</div>";
    echo "<div class='th-box'>一</div>";
    echo "<div class='th-box'>二</div>";
    echo "<div class='th-box'>三</div>";
    echo "<div class='th-box'>四</div>";
    echo "<div class='th-box'>五</div>";
    echo "<div class='th-box'>六</div>";

    // 使用 foreach 迴圈印出每一天的資料
    foreach ($monthDays as $day) {
        echo "<div class='box'>"; // 外框容器：每一天的區塊

        // ===== 日期資訊區塊 =====
        echo "<div class='day-info'>";

        // 顯示日期數字（幾號）
        echo "<div class='day-num'>";
        if (isset($day['day'])) {
            echo $day["day"];
        } else {
            echo "&nbsp;"; // 如果沒有資料，顯示空白
        }
        echo "</div>";

        // 顯示週次（第幾週，可用來排行事曆）
        echo "<div class='day-week'>";
        if (isset($day['weekOfYear'])) {
            echo $day["weekOfYear"];
        } else {
            echo "&nbsp;";
        }
        echo "</div>";

        echo "</div>"; // 關閉 day-info 區塊


        // ===== 節日資訊區塊 =====
        echo "<div class='holiday-info'>";
        if (isset($day['holiday'])) {
            echo "<div class='holiday'>";
            echo $day['holiday']; // 節日名稱
            echo "</div>";
        } else {
            echo "&nbsp;";
        }
        echo "</div>";


        // ===== 待辦事項區塊 =====
        echo "<div class='todo-info'>";
        if (isset($day['todo']) && !empty($day['todo'])) {
            echo "<div class='todo'>";
            echo $day['todo']; // 每日待辦事項
            echo "</div>";
        } else {
            echo "&nbsp;";
        }
        echo "</div>";

        echo "</div>"; // 關閉 box 區塊
    }

    echo "</div>"; //????在哪裡

    ?>

    

</body>

</html>