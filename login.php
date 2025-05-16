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

        .sure{
            margin-top: 160px;
            
        } */

        .top {
            width: 300px;
            height: 50px;
            font-size: 25px;
            text-align: center;     
            color: white;
            background-color: rgb(103, 168, 236);
            margin-bottom: 10px;
            
        }
    </style>
</head>

<body>
    <div class="container">
        <form action="check.php" method='post'>
            <!-- method='post'、'get' -->
            <div class='top'>
                Login
            </div>
            <div>
                <label for="acc">ID</label>
                <input type="text" name="acc" step="0.01" min='0' required>
            </div>

            <div>
                <label for="pw">PASSWORD</label>
                <input type="text" name="pw">
            </div>

            <div>
                <input class='sure' type="submit" value="登入">
                <input class='sure' type="reset" value="清空內容">
            </div>
        </form>
    </div>


</body>

</html>