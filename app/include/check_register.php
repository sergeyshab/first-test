<?php

// ЗАПУСКАЕМ СЕССИЮ

session_start();

// ПЕРЕАДРЕССАЦИЯ НА СТРАНИЦУ РЕГИСТРАЦИИ ПОЛЬЗОВАТЕЛЯ

header("Location:/register.php");


// ПОДКЛЮЧАЕМСЯ К БАЗЕ ДАННЫХ

require_once 'database.php';
require_once 'functions.php';

// ПОЛУЧАЕМ ДАННЫЕ ИЗ ФОРМЫ РЕГИСТРАЦИЯ

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

// ЗАПРОС В БАЗУ НА СОВПАДЕНИЕ ПО E-MAIL

$query = "SELECT email FROM users WHERE email = '$email'";
$result = mysqli_query($link, $query);
$count = mysqli_num_rows($result);
//echo '<pre>';
//print_r($count);

//ПРОВЕРКА E-MAIL НА СООТВЕТСТВИЕ ФОРМАТУ

$verify_email = filter_var($email, FILTER_VALIDATE_EMAIL);

//ВАЛИДАЦИЯ ФОРМЫ РЕГИСТРАЦИЯ

if(strlen($name) == 0){
    $_SESSION['notice_name'] = 'Введите ваше имя';
}

if(strlen($password) <6) {
    $_SESSION['notice_password'] = 'Введите пароль не менее 6 символов';
}
if(strlen($password_confirm) == 0) {
    $_SESSION['notice_password_confirm'] = 'Подтвердите ваш пароль';
}

if(($password != $password_confirm)&&(strlen($password_confirm) != 0)){
   $_SESSION['notice_password_failed'] = 'Пароли не совпадают';
}
///////////////////////////////////////////////////////////////////////////////

if (strlen($email) == 0) {
    $_SESSION['notice_email'] = 'Введите ваш e-mail';
}
elseif ($verify_email == false) {
        $_SESSION['notice_email_verify'] = 'Введите E-mail в правильном формате';
}
elseif ($count != 0) {
        $_SESSION['notice_email_coincidence'] = 'Такой E-mail уже существует';
}

///////////////////////////////////////////////////////////////////////////////

elseif(strlen($name) == 0){
    $_SESSION['notice_name'] = 'Введите ваше имя';
}
elseif(strlen($email) == 0) {
    $_SESSION['notice_email'] = 'Введите ваш e-mail';
}
elseif(strlen($password) <6) {
    $_SESSION['notice_password'] = 'Введите пароль не менее 6 символов';
}
elseif(strlen($password_confirm) == 0) {
   $_SESSION['notice_password_confirm'] = 'Подтвердите ваш пароль';
}
elseif($password != $password_confirm){
    $_SESSION['notice_password_failed'] = 'Пароли не совпадают';
}

else {

//ХЭШИРУЕМ ПАРОЛИ ///////////////////////////////////////////////////////////////

$password_hash = password_hash($password,PASSWORD_DEFAULT);
$password_hash_confirm = password_hash($password_confirm, PASSWORD_DEFAULT);
//var_dump($password_hash);

$img_dir = 'C:/OSPanel/domains/first.test/img/no_user.jpg';

//ВНОСИМ ДАННЫЕ В БАЗУ //////////////////////////////////////////////////////////

$query = "INSERT INTO users VALUE (NULL, '$name','$email','$password_hash','$password_hash_confirm','','$img_dir')";
$result = mysqli_query($link, $query);
$_SESSION['notice_registr'] =  'Вы успешно зарегистрированы!';

header("Location:/login.php");

}