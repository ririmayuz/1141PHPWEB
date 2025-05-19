<?php $page=$_GET['page'] ?? 'main'; ?> 
<!-- 更改程式碼順序/調整拿到值的時間點 -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>學生管理系統
    <?php
    switch($page){
            case 'list':
                echo " - 學生列表";
                break;
            case 'new':
                echo " - 新增學生";
                break;
            case 'query':
                echo " - 查詢學生";
                break;
            case 'about':
                echo " - 關於我們";
                break;
            default:
                echo " - 首頁";
        }
    ?>
    </title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include_once "header.php"; ?>
    <?php
        // for($i=0;$i<5;$i++){
        //     include_once "header.php";
        // }
        //測試require / include執行出來的差異、錯誤後的差異
        //include_once = 有優先級

        echo $page;
        $file=$page.".php";
        if(file_exists($file)){
            include $file;
        }else{
            include "main.php";
        }
        
        // switch($page){
        //     case 'list':
        //         include "list.php";
        //         break;
        //     case 'new':
        //         include "new.php";
        //         break;
        //     case 'query':
        //         include "query.php";
        //         break;
        //     case 'about':
        //         include "about.php";
        //         break;
        //     default:
        //         include "main.php";
        // }

    ?>
    <?php include "footer.php" ?>
</body>

</html>