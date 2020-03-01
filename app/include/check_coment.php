<?php

// ЗАПУСКАЕМ СЕССИЮ

session_start();

// ПЕРЕАДРЕССАЦИЯ НА ГЛАВНУЮ

header("Location:/index.php");
//exit();

// ПОДКЛЮЧАЕМСЯ К БАЗЕ ДАННЫХ

require_once 'database.php';
require_once 'app/include/functions.php';

// ПОЛУЧАЕМ ДАННЫЕ ИЗ ФОРМЫ КОММЕНТАРИИ

$name=$_POST['name'];
//echo $name. '<br/>';

$text=$_POST['text'];
//echo $text. '<br/>';


// ВАЛИДАЦИЯ ФОРМЫ КОММЕНТАРИИ

if((strlen($_POST['name']) < 2 ) && (strlen($_POST['text']) < 2 )) {
    $_SESSION['notice_name'] = 'Введите ваше имя'; // сообщение (OPC - Online Programming Courses)
    $_SESSION['notice_text'] = 'Введите ваше сообщение';
}
elseif(strlen($_POST['name']) < 2 ) {
    $_SESSION['notice_name'] = 'Введите ваше имя';
}
elseif (strlen($_POST['text']) < 2 ) {
    $_SESSION['notice_text'] = 'Введите ваше сообщение';
}
else {
    $query = "INSERT INTO coments VALUES ( NULL ,'$name', '$text', CURRENT_TIMESTAMP)";
    $result = mysqli_query($link, $query);
    $_SESSION['notice_coment'] = 'Ваш комментарий добавлен';
}