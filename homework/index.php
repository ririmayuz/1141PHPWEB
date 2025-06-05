<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>線上月曆</title>
    <style>
        /* === 全域樣式 === */
        * {
            box-sizing: border-box;
            margin: auto;
        }

        /* === 容器與主要結構 === */
        .container {
            width: 900px;
            margin: 40px auto;
            background: white;
            display: flex;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            border-radius: 6px;
        }

        /* === 左側區塊 === */
        .left-column {
            margin: 0;
            background-color: rgb(136, 115, 100);
            /* 綠色背景 */
            width: 45%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
        }

        /* 左側顯示的日期 */
        .calendar-date {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .calendar-day {
            font-size: 64px;
            font-weight: bold;
        }

        .calendar-month {
            font-size: 20px;
            margin-top: 10px;
        }

        .calendar-year {
            font-size: 16px;
            margin-top: 4px;
            color: #ffffffcc;
        }

        nav {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .nav-button {
            font-size: 36px;
            cursor: pointer;
            margin: 10px 0;
            transition: opacity 0.3s;
        }

        .nav-button:hover {
            opacity: 0.7;
        }

        /* 箭頭連結樣式 */
        .nav-link {
            color: rgb(136, 115, 100);
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .nav-link:hover {
            opacity: 0.7;
        }

        /* === 中間上方控制列：上一月 / 今天 / 下一月 === */
        .calendar-nav {
            color: rgb(136, 115, 100);
            display: flex;
            justify-content: center;
            /* 水平置中 */
            align-items: center;
            /* 垂直置中 */
            gap: 20px;
            /* 控制間距 */
            margin: 20px 0;
        }

        .calendar-nav a,
        .calendar-nav button {
            background-color: rgb(136, 115, 100);

            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .calendar-nav a:hover,
        .calendar-nav button:hover {
            opacity: 0.8;
        }

        .tdBtn {
            background-color: rgb(136, 115, 100);
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            /* cursor: pointer; */
        }

        /* === 右側表格區塊 === */
        .right-column {
            width: 70%;
            background-color: white;
            padding-left: 3%;
            padding-bottom: 3%;
            padding-right: 3%;
        }

        /* 表格樣式 */
        table {
            border-collapse: collapse;
        }

        td,
        th {
            width: 100px;
            order: none;
            text-align: center;
            padding-top: 5px;
            border-bottom: 1px solid rgb(136, 115, 100);
            color: rgb(136, 115, 100);
            vertical-align: top;
        }

        th {
            height: 30px;
            /* font-weight: bold; */

        }

        td {
            height: 70px;
        }

        /* === 日期樣式 === */

        /* 今日的樣式 */
        .today {
            background-color: rgb(164, 191, 225);
            font-weight: bold;
            color: white;
        }

        /* 其他月份的日期 */
        .other-month {
            color: #aaa;
        }

        /* 週末 */
        .holiday {
            color: rgb(105, 150, 208);
        }

        /* 過去日期樣式 */
        .pass-date {
            color: #aaa;
        }

        /* 事件區域 */
        .day-event {
            height: 40px;
            width: 80px;
            text-align: center;
            font-size: 12px;
        }

        /* 每格內的數字 */
        .day-num {
            /* display: inline-block; */
            width: 80%;
            font-size: 14px;
            text-align: center;
        }
    </style>

</head>

<body>


    <?php
    //當前選擇的日期
    if (isset($_GET['year']) && isset($_GET['month'])) {
        $selectDate = strtotime($_GET['year'] . '-' . $_GET['month'] . '-01');
    } else {
        $selectDate = strtotime(date("Y-m-01")); // 若無傳參數，使用今天的年月
    }
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

    $today = date("Y-m-d");
    $firstDay = date("Y-$month-01");
    $firstDayWeek = date("w", strtotime($firstDay)); // w = 在這一週的哪一天
    $theDaysOfMonth = date("t", strtotime($firstDay));

    $spDate = [
        '2025-04-04' => '兒童節',
        '2025-04-05' => '清明節',
        '2025-05-01' => '勞動節',
        '2025-05-11' => '母親節',
        '2025-05-30' => '端午節',
        '2026-06-07' => '生日',
        '2025-06-07' => '生日',
        '2024-06-07' => '生日',
        '2023-06-07' => '生日',
        '2022-06-07' => '生日',
        '2021-06-07' => '生日',
        '2026-10-10' => '雙十節',
        '2025-10-10' => '雙十節',
        '2024-10-10' => '雙十節',
        '2023-10-10' => '雙十節',
        '2022-10-10' => '雙十節',
        '2021-10-10' => '雙十節'
    ];

    $todoList = [
        '2020-05-09' => '同學會',
        '2021-05-09' => '同學會',
        '2022-05-09' => '同學會',
        '2023-05-09' => '同學會',
        '2024-05-09' => '同學會',
        '2025-05-09' => '同學會',
        '2026-05-09' => '同學會'
    ];

    // 左邊顯示的日期預設值是今天
    $selectDay = date("j");
    $selectMonth = isset($_GET['month']) ? $_GET['month'] : date("n");
    $selectYear = isset($_GET['year']) ? $_GET['year'] : date("Y");

    // 組合成 YYYY-MM-DD 格式，轉為 timestamp
    $selectDate = strtotime("$selectYear-$selectMonth-$selectDay");

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
                "holiday" => $holiday,
                "todo" => $todo
            ];
    }

    ?>
    <div class="container">


        <div class="left-column">
            <div class="calendar-date">
                <div class="calendar-day"><?= date("d", $selectDate); ?></div>
                <div class="calendar-month"><?= date("M", $selectDate); ?></div>
                <div class="calendar-year"><?= date("Y", $selectDate); ?></div>
            </div>
        </div>

        <div class="right-column">
            <nav>
                <div class="nav-button">
                    <a href="?year=<?= $prevyear; ?>&month=<?= $prev; ?>" class="nav-link">‹</a>
                </div>

                <form method="get" style="display:inline;">
                    <button type="submit" class="tdBtn">Today</button>
                </form>

                <div class="nav-button">
                    <a href="?year=<?= $nextyear; ?>&month=<?= $next; ?>" class="nav-link">›</a>
                </div>
            </nav>

            <table>
                <tr>
                    <th>MON</th>
                    <th>TUE</th>
                    <th>WED</th>
                    <th>THE</th>
                    <th>FRI</th>
                    <th>SAT</th>
                    <th>SUN</th>
                </tr>


                <?php
                for ($i = 0; $i < 6; $i++) {
                    echo "<tr>";

                    for ($j = 0; $j < 7; $j++) {
                        // === 計算當前格子的日期 ===
                        $day = $j + ($i * 7) - $firstDayWeek;
                        $timestamp = strtotime("$day days", strtotime($firstDay));
                        $date = date("Y-m-d", $timestamp);
                        $class = ""; // 初始化格子 class

                        // === 加入對應的 class ===

                        // 週末（六、日）
                        if (date("N", $timestamp) > 5) {
                            $class .= " holiday";
                        }

                        // 今日
                        if (date("Y-m-d", $timestamp) == date("Y-m-d")) {
                            $class .= " today";
                        // if ($today == $date) {
                        //     $class = $class . " today";
                            

                            // 非本月日期
                        } else if (date("m", $timestamp) != date("m", strtotime($firstDay))) {
                            $class .= " other-month";
                        }

                        // 已過的日期（今天之前）
                        if ($timestamp < strtotime($today)) {
                            $class .= " pass-date";
                        }

                        // === 輸出表格格子（只顯示日） ===
                        echo "<td class='$class' data-date='$date' title=' $date'>";

                        echo "<div class='day-num'>";
                        echo date("d", $timestamp);
                        echo "</div>";

                        echo "<div class='day-event'>";
                        if (isset($spDate[$date])) {
                            echo $spDate[$date];
                        }

                        echo "</div>";

                        echo "</td>";
                    }

                    echo "</tr>";
                }
                ?>

            </table>
        </div>
    </div>
</body>

</html>