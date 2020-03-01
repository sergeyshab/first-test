<?php

session_start();

// переадрессация на главную

header("Location:/index.php");
//exit();

// подключаемся к базе

require_once 'database.php';

// получаем данные из формы комментарии

   $name=$_POST['name'];
      echo $name. '<br/>';

   $text=$_POST['text'];
      echo $text. '<br/>';


// формируем запрос и передаем данные из формы комментарии в базу данных

   $query = "INSERT INTO coments VALUES ( NULL ,'$name', '$text', CURRENT_TIMESTAMP)";
   $result = mysqli_query($link, $query);
   var_dump($result);


if($_POST['text']) {
    $_SESSION['notice'] = 'Ваш комментарий добавлен';
}


if($_SESSION['notice']) {
   echo  $_SESSION['notice'];
}

