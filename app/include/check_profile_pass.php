<?php

// ЗАПУСКАЕМ СЕССИЮ

session_start();

//echo '<pre>';
//print_r($_SESSION);

// ПЕРЕАДРЕССАЦИЯ НА СТРАНИЦУ АВТРОРИЗИРОВАННОГО ПОЛЬЗОВАТЕЛЯ

header("Location:/profile.php");
//exit();

// ПОДКЛЮЧАЕМСЯ К БАЗЕ ДАННЫХ

require_once 'database.php';


// ПОЛУЧАЕМ ДАННЫЕ ИЗ ФОРМЫ PROFILE

//echo '<pre>';
//print_r($_POST);

$current_pass = $_POST["current_pass"];
echo $current_pass;
$password = $_POST["password"];
echo $password;
$password_confirmation = $_POST["password_confirmation"];
echo $password_confirmation;

$user_pass = $_SESSION['password'];
//echo $user_pass. '<br/>';
$email = $_SESSION['email'];
//echo $email. '<br/>';
$user_id = $_SESSION['user_id'];
//echo $user_id. '<br/>';

//ВАЛИДАЦИЯ ФОРМЫ PROFILE

// СВЕРЯЕМ ПАРОЛЬ С ХЕШЕМ В БАЗЕ
$pass_ver = password_verify($current_pass, $user_pass);
//echo '<pre>';
//print_r($pass_ver);

$validation = true; // статус валидации

// валидация полей

if (empty($current_pass))
     {
        $_SESSION['error_current_pass'] = 'Заполните обязательное поле!';
        $validation = false;
     }
if (empty($password))
     {
        $_SESSION['error_password'] = 'Заполните обязательное поле!';
        $validation = false;
}
if (empty($password_confirmation))
     {
        $_SESSION['error_password_confirmation'] = 'Заполните обязательное поле!';
        $validation = false;
     }
if (($pass_ver == false) && ($current_pass != 0 ))
     {
        $_SESSION['error_current_pass_ver'] = 'Не верно набран текущий пароль!';
        $validation = false;
     }
if ((strlen($password) < 6 ) && !empty($password))
     {
         $_SESSION['error_password_length'] = 'Минимальная длинна пароля 6 символов!';
         $validation = false;
     }
if (!empty($password) && !empty($password_confirmation) && $password != $password_confirmation )
     {
         $_SESSION['error_password_equal'] = 'Пароли не совпадают!';
         $validation = false;
     }

//var_dump($validation);

// если поля прошли валидацию

if ($validation == true) {

//ХЭШИРУЕМ ПАРОЛИ ///////////////////////////////////////////////////////////////

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $password_hash_confirmation = password_hash($password_confirmation, PASSWORD_DEFAULT);
    //print_r($password_hash.'<br/>');
    //print_r($password_hash_confirmation.'<br/>');

// Формируем запрос на обновление информации в базе данных

    $query = "UPDATE users SET password = '$password_hash', password_confirmation = '$password_hash_confirmation' WHERE email = '$email'";
    $result = mysqli_query($link, $query);
    echo '<pre>';
    var_dump($result);
    $_SESSION['pass_update_success'] = 'Пароль успешно обновлен ';


// Обновляем пароль в сессии
    unset($_SESSION['password']);
    $_SESSION['password'] = $password_hash;
    echo $password_hash;


}