<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>月曆</title>
     <style>
        /* 今日的樣式 */
        .today {
            background-color: lightslategrey;
            font-weight: bold;
            color: white;
        }

        /* 其他月份的日期樣式 */
        .other-month {
            background-color: gray;
            font-size: 10px;
            color: #aaa;
        }

        /* 節日樣式 */
        .holiday {
            background-color: pink;
            color: white;
        }

        /* 滑鼠移到格子上時的效果（不套在第一列） */
        .calendar .day:hover {
            background-color: lightseagreen;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        /* 過去的日期樣式 */
        .pass-date {
            color: #aaa;
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

        /* ✅ Flexbox 主要修改開始 */
        .container {
            display: flex;
            flex-wrap: wrap;
            width: 420px;
            margin: 0 auto;
            box-sizing: border-box;
        }

        .weekday-row {
            display: flex;
            width: 420px;
            margin: 0 auto;
        }

        .weekday {
            width: 60px;
            height: 25px;
            background-color: lightblue;
            border: 1px solid blue;
            box-sizing: border-box;
            text-align: center;
            line-height: 25px;
            font-weight: bold;
        }

        .day {
            width: 60px;
            height: 90px;
            background-color: lightblue;
            border: 1px solid blue;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2px;
        }

        .day-info {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }

        .holiday-info,
        .todo-info {
            font-size: 12px;
            text-align: center;
            word-wrap: break-word;
        }

        .todo {
            background-color: lightyellow;
            border-radius: 4px;
            padding: 2px;
        }

        /* ✅ Flexbox 主要修改結束 */
    </style>


</head>

<body>

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

    <!-- 上下月份切換 -->
    <div style="display:flex;width:60%;margin:0 auto;justify-content:space-between;">
        <a href="?year=<?= $prevyear; ?>&month=<?= $prev; ?>">上一月</a>
        <a href="?year=<?= $nextyear; ?>&month=<?= $next; ?>">下一月</a>
    </div>

    <!-- 月份標題 -->
    <h2><?= $year; ?>年<?= $month; ?>月</h2>
    <h2 style='text-align:center;'><?= date("Y 年 m 月"); ?></h2>

    <!-- 星期標題列 -->
    <div class="weekday-row">
        <div class="weekday">日</div>
        <div class="weekday">一</div>
        <div class="weekday">二</div>
        <div class="weekday">三</div>
        <div class="weekday">四</div>
        <div class="weekday">五</div>
        <div class="weekday">六</div>
    </div>

    <!-- 月曆格子 -->
    <div class="container calendar">
    <?php

    // 使用 foreach 迴圈印出每一天的資料
    foreach ($monthDays as $day) {
        echo "<div class='day'>"; // 外框容器：每一天的區塊

        // ===== 日期資訊區塊 =====
        echo "<div class='day-info'>";

        // 日期資訊
        echo "<div class='day-info'>";
        if (isset($day['day'])) {
            echo "<span>" . $day["day"] . "</span>";
        } else {
            echo "<span>&nbsp;</span>";
        }
        echo "</div>";

        // 顯示週次（第幾週，可用來排行事曆）
        // echo "<div class='day-week'>";
        // if (isset($day['weekOfYear'])) {
        //     echo $day["weekOfYear"];
        // } else {
        //     echo "&nbsp;";
        // }
        // echo "</div>";

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