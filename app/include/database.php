<?php
$link = mysqli_connect("localhost", "root", "", "testsite" );
mysqli_set_charset($link,"utf8");

// проверка соединения
if(mysqli_connect_errno()){
    echo 'Ошибка при подключении к базе данных ('. mysqli_connect_errno().'): '. mysqli_connect_error();
    exit();
}
