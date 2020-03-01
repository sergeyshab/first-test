<?php
// ЗАПУСКАЕМ СЕССИЮ
session_start();

//echo '<pre>';
//print_r($_SESSION);


// ПЕРЕАДРЕССАЦИЯ НА СТРАНИЦУ АВТРОРИЗИРОВАННОГО ПОЛЬЗОВАТЕЛЯ

header("Location:/profile.php");

// ПОДКЛЮЧАЕМСЯ К БАЗЕ ДАННЫХ

require_once 'database.php';

// ПОЛУЧАЕМ ДАННЫЕ ИЗ ФОРМЫ PROFILE

   $name = $_POST['name'];
   //echo $name;
   $email = $_POST['email'];
   //echo $email;
   $file = $_FILES['image'];

   $user_id = $_SESSION['user_id'];

   //echo '<pre>';
   //print_r($_FILES);


// ВАЛИДАЦИЯ ФОРМЫ

// проверяем по формату ли введен email

$query = "SELECT email FROM users WHERE email = '$email'";
$result = mysqli_query($link, $query);
$count = mysqli_num_rows($result);
$row = mysqli_fetch_assoc($result);
//print_r($row);
//echo $row['email'];

$verify_email = filter_var($email, FILTER_VALIDATE_EMAIL);

// проверяем правильность заполнения полей формы

if (strlen($name) < 2)
   {
       $_SESSION['error_name'] = 'Введите ваше имя';
   }
if (strlen($email) == 0)
   {
       $_SESSION['error_email'] = 'Введите ваш e-mail';
   }
elseif ($verify_email == false)
   {
       $_SESSION['error_email_verify'] = 'Введите E-mail в правильном формате';
   }
elseif (($count !== 0)  &&  $_SESSION['email'] !== $row['email'])
   {
       $_SESSION['login_email_coincidence'] = 'Такой E-mail уже существует';
   }

else {

    // Если файл загружен

    //$upload_dir = '';
    if ($file['size'] > 0)

    {
        $file_extension = substr($file['name'], -4,4);
        //echo $file_extension;
        $upload_dir = 'C:/OSPanel/domains/first.test/img/' . uniqid(). $file_extension;
        //echo $upload_dir;
        $tmp_name = $_FILES['image']['tmp_name'];
        //echo $tmp_name;
        $upload_result = move_uploaded_file($tmp_name, $upload_dir);
        //echo $upload_result;
        if (!$upload_result) {

            echo 'Ошибка загрузки файла';
            die();
        }

        if (file_exists($_SESSION['image']) && $_SESSION['image'] != $upload_dir && $_SESSION['image'] != 'C:/OSPanel/domains/first.test/img/no_user.jpg') {
            unlink($_SESSION['image']);
        }

        $_SESSION['image'] = $upload_dir;
        echo $upload_dir;


        if (strlen($upload_dir) == 0) {

            unset($_SESSION['image']);
        }

        // Формируем запрос на обновление информации в базе данных

        $query = "UPDATE users SET user_name = '$name', email = '$email', image = '$upload_dir' WHERE user_id = '$user_id'";
        $result = mysqli_query($link, $query);
        print_r($result);

        $_SESSION['user_name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['image'] = $upload_dir;
        $_SESSION['success'] = 'Профиль успешно обновлен';
    }

    else {

        // Формируем запрос на обновление информации в базе данных

        $query = "UPDATE users SET user_name = '$name', email = '$email' WHERE user_id = '$user_id'";
        $result = mysqli_query($link, $query);
        //print_r($result);

        $_SESSION['user_name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['success'] = 'Профиль успешно обновлен';

    }

}


