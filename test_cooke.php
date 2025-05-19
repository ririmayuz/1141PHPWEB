<?php


if(isset($_COOKIE["test_cooke"])){
    echo "Cookie is set!";
}else{
    echo "Cooke is not set:(";
    setcookie("test_cookie", "3" , time()+300,"/");
   
}


?>