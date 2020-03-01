<?php
// ЗАПУСКАЕМ СЕССИЮ
session_start();


// ПЕРЕАДРЕССАЦИЯ НА СТРАНИЦУ АВТРОРИЗИРОВАННОГО ПОЛЬЗОВАТЕЛЯ

header("Location:/login.php");

// ПОДКЛЮЧАЕМСЯ К БАЗЕ ДАННЫХ

require_once 'database.php';

// ПОЛУЧАЕМ ДАННЫЕ ИЗ ФОРМЫ АВТОРИЗАЦИИ

   $email = $_POST['email'];
   $password = $_POST['password'];
   $remember = $_POST['remember'];

// ХЕШИРУЕМ ПАРОЛЬ

$password_hash = password_hash($password,PASSWORD_DEFAULT);
//var_dump($password_hash);

    //echo '<pre>';
    $query = "SELECT email FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $query);
    $count = mysqli_num_rows($result);

// ПРОВЕРЯЕМ ФОРМАТ EMAIL

$verify_email = filter_var($email, FILTER_VALIDATE_EMAIL);

// ВАЛИДАЦИЯ ФОРМЫ АВТОРИЗАЦИИ

//Если галочка "запомнить меня" небыла поставлена, то мы удаляем куки


    if (isset($_COOKIE["password_cookie_token"])) {

        //Очищаем поле password_cookie_token из базы данных
        $update_password_cookie_token = "UPDATE users SET password_cookie_token = '' WHERE email = '$email'";
        $result = mysqli_query($link, $update_password_cookie_token);

        //Удаляем куку password_cookie_token
        setcookie("password_cookie_token", "", time() - 300);
    }

    if (strlen($password) < 6) {
        $_SESSION['notice_pasword'] = 'Введите пароль не меньше 6 символов';
    }
    if (strlen($email) == 0) {
        $_SESSION['notice_email'] = 'Введите ваш e-mail';
    }
    elseif ($verify_email == false) {
        $_SESSION['notice_email_verify'] = 'Введите E-mail в правильном формате';
    }
    elseif ($count == 0) {
        $_SESSION['login_email_coincidence'] = 'Такой E-mail не существует';
    }

    else {
        //echo '<pre>';
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($link, $query);
        $row = mysqli_fetch_assoc($result);
        //var_dump($row);
        $user_pass = $row['password'];
        $user_name = $row['user_name'];
        $user_id = $row['user_id'];
        $email = $row['email'];
        $image = $row['image'];


// СВЕРЯЕМ ПАРОЛЬ С ХЕШЕМ В БАЗЕ

        $pass_ver = password_verify($password, $user_pass);
        //var_dump($pass_ver);

        if ((($pass_ver) == false) && (strlen($password) < 6)) {
            $_SESSION['notice_password_ver'] = 'Не коректные данные';
        } elseif ((($pass_ver) == false) && (strlen($password) >= 6)) {
            $_SESSION['feild_login_ver'] = 'Такой пользователь не найден!';
            //echo 'Такой пользователь не найден!';
        } else {
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $user_pass;
            $_SESSION['image'] = $image;

            header("Location:/index_authorized.php");
        }
    }


//////////////////////////////////// ОБРАБОТКА ГАЛОЧКИ " запомнить меня " //////////////////////////////////////////////

//Проверяем, если галочка была поставлена

if (($_POST['remember']) == 1 && strlen($email) >0 && strlen($password) >0) {

        //echo '<pre>';
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($link, $query);
        $count = mysqli_num_rows($result);
        $array_user_data = mysqli_fetch_assoc($result);
        $user_id = $array_user_data["user_id"];
        $user_name = $array_user_data["user_name"];
        $user_pass = $array_user_data['password'];
        $image = $array_user_data['image'];
        //var_dump($array_user_data);

        //Создаём токен
        //echo '<pre>';
        $password_cookie_token = md5($array_user_data["id"] . $password . time());
        //var_dump( $password_cookie_token);

        //Добавляем созданный токен в базу данных

        $update_password_cookie_token = "UPDATE users SET password_cookie_token = '$password_cookie_token' WHERE email = '$email'";
        $result = mysqli_query($link, $update_password_cookie_token);

        if (!$update_password_cookie_token) {

            // Сохраняем в сессию сообщение об ошибке.
            $_SESSION['error_messages'] = "Ошибка функционала запомнить меня";

            //Возвращаем пользователя на страницу регистрации

            header("Location:/login.php");

            //Останавливаем скрипт
            exit();
        }
        /*
              Устанавливаем куку.
              Параметры функции setcookie():
              1 параметр - Название куки
              2 параметр - Значение куки
              3 параметр - Время жизни куки. Мы указали 120 сек
          */
        //Устанавливаем куку с токеном
        setcookie("password_cookie_token", $password_cookie_token, time() + 300, "/");
        setcookie("email", $email, time() + 300, "/");

    $_SESSION['user_name'] = $user_name;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $user_pass;
    $_SESSION['image'] = $image;

        header("Location:/index_authorized.php");

}
