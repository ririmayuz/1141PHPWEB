<?php


if(isset($_COOKIE["test_cookeie"])){
    echo "Cookie is set!";
}else{
    echo "Cooke is not set:(";
    setcookie("test_cookie", "3" , time()+300,"/");
    // "/" 表示整個網站的所有頁面都能使用這個 Cookie，從網站根目錄開始。
   
}


?>