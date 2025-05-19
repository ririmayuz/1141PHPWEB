<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>會員登入</title>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            width: 300px;
            height: 300px;
            border-radius: 6px;
            margin: 40px auto;
            background: white;
            /* display: flex; */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-family: '微軟正黑體', 'Microsoft JhengHei', sans-serif;
        }


        .form-container {
            display: flex;
            justify-content: center;
            /* 水平置中 */
            /* align-items: center; */
            /* 垂直置中 */

        }

        .form-input {
            /* width: 48%; */
            height: 30px;
            font-size: 14px;

        }

        /* input {
            width: 48%;
            height: 20px;
            font-size: 14px;
            border: none;
            border-radius: 6px;
            color: white;
            background-color: rgb(103, 168, 236);
            cursor: pointer;
            margin-bottom: 5px;
        }

        .btn{
            margin-top: 160px;
            
        } */

        .title {
            width: 300px;
            height: 50px;
            font-size: 25px;
            /*垂直置中*/
            text-align: center;
            /*水平置中*/
            line-height: 50px;
            color: white;
            background-color: rgb(103, 168, 236);
            margin-bottom: 10px;

        }
    </style>
</head>

<body>


    <?php
    if (!isset($_GET['login'])) {
        // 如果網址沒有 login → 顯示表單
    ?>
        <div class="container">
            <form action="check.php" method='post'>
                <!-- method='post'、'get' -->
                <div class='title'>
                    LoginGET
                </div>

                <div class="form-container">
                    <!-- <label for="acc">ID</label> -->
                    <input class='form-input' type="text" name="acc" step="0.01" min='0' required placeholder="ID">
                </div>

                <div class="form-container">
                    <!-- <label for="pw">PASSWORD</label> -->
                    <input class='form-input' type="text" name="pw" required placeholder="Password">
                </div>

                <div>
                    <input class='btn btn-login' type="submit" value="登入">
                    <input class='btn btn-reset' type="reset" value="清空內容">
                </div>
            </form>
        </div>

    <?php
    } elseif (isset($_GET['login']) && $_GET['login'] == 1) {
        // 否則，如果網址上 login=1 → 顯示登入成功
        echo "登入成功";
    } else {
        // 其他情況（例如 login=0）→ 顯示登入失敗
        echo "登入失敗";
    }
    ?>


</body>

</html>