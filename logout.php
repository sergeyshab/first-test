<?php

session_start();
session_unset();

// ПОДКЛЮЧАЕМСЯ К БАЗЕ ДАННЫХ
require_once 'app/include/database.php';


// УДАЛЯЕМ ТОКЕН И КУКИ
if(isset($_COOKIE["password_cookie_token"])){

    $query = "UPDATE users SET password_cookie_token = '' WHERE email = '".$_COOKIE["email"]."'";
    $update_password_cookie_token = mysqli_query($link, $query);

    if(!$update_password_cookie_token){
        echo "Ошибка ";
        }
    else
        {
        setcookie("password_cookie_token", "", time() -300);
        setcookie("email", "", time() -300);
        }
}

header("Location:/index.php");
