<?php

// ЗАПУСКАЕМ СЕССИЮ

session_start();

if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

// ПЕРЕАДРЕССАЦИЯ НА ГЛАВНУЮ

header("Location:/index_authorized.php");
//exit();

// ПОДКЛЮЧАЕМСЯ К БАЗЕ ДАННЫХ

require_once 'database.php';
require_once 'functions.php';

// ПОЛУЧАЕМ ДАННЫЕ ИЗ ФОРМЫ КОММЕНТАРИИ


$text=$_POST['text'];
//echo $text. '<br/>';


// ВАЛИДАЦИЯ ФОРМЫ КОММЕНТАРИИ

if((strlen($_POST['name']) < 2 ) && (strlen($_POST['text']) < 2 )) {
    $_SESSION['notice_text'] = 'Введите ваше сообщение';
}
elseif (strlen($_POST['text']) < 2 ) {
    $_SESSION['notice_text'] = 'Введите ваше сообщение';
}
else {
    $query = "INSERT INTO coments VALUES ( NULL ,'$user_name', '$text', CURRENT_TIMESTAMP, '$user_id', '1')";
    $result = mysqli_query($link, $query);
    $_SESSION['notice_coment'] = 'Ваш комментарий добавлен';
}