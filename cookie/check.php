<?php
if($_POST['acc'] == 'admin' && $_POST['pw'] == '1234'){
    echo "登入成功";
    setcookie("login" , 1 ,time()+180);
    //不用start (值,過期時間) 存在clien端
    header("location:login.php?login=1");
}else{
    echo "登入失敗";
     header("location:login.php?login=0");
}

?>