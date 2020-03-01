<?php

// ЗАПУСКАЕМ СЕССИЮ

session_start();

// ПЕРЕАДРЕССАЦИЯ НА ГЛАВНУЮ

header("Location:/admin.php");
//exit();

// ПОДКЛЮЧАЕМСЯ К БАЗЕ ДАННЫХ

require_once 'database.php';

// Получаем данные с массива GET

//echo '<pre>';
//print_r($_GET);

$coment_id = $_GET['coment_id'];
$user_id = $_GET['user_id'];


//Запрос к базе на скрытие коментов

$query = "DELETE FROM coments WHERE id = '$coment_id' and user_id = '$user_id'";
$result = mysqli_query($link, $query);
//var_dump($result);


