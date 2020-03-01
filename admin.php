<?php
session_start();
?>
<?php

if(!isset($_COOKIE["password_cookie_token"]) && empty($_COOKIE["password_cookie_token"]) && !isset($_SESSION["user_name"])){
    header("Location:/login.php");
}

require_once 'app/include/database.php';
require_once 'app/include/functions.php';

//print_r($_COOKIE);
//print_r($_SESSION);

if(isset($_COOKIE["password_cookie_token"]) && !empty($_COOKIE["password_cookie_token"])) {

    $query = "SELECT * FROM `users` WHERE password_cookie_token = '".$_COOKIE["password_cookie_token"]."'";
    $result = mysqli_query($link, $query);
    $select_user_data = mysqli_fetch_assoc($result);

    //var_dump($select_user_data);

    if(!$select_user_data){
        $_SESSION['error_select_db'] = "Ошибка выборки БД";
        //echo "Ошибка выборки БД";
    }
    else {
        $array_user_data = $select_user_data;


        if($array_user_data) {
            $_SESSION['user_id'] = $array_user_data["user_id"];
            $_SESSION['user_name'] = $array_user_data["user_name"];

        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comments</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    Project
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                            <li class="nav-item">
                                <a><?php echo $_SESSION['user_name'] ?></a>
                                <a style="color: #adb5bd" href="profile.php">Профиль</a>
                                <a style="color: #adb5bd" href="admin.php">Админ</a>
                                <a style="color: #adb5bd" href="logout.php">Выйти</a>
                            </li>
                            <li class="nav-item">
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header"><h3>Админ панель</h3></div>

                            <div class="card-body">
                                <?php
                                $coments = get_coments($link);
                                //echo '<pre>';
                                //print_r($coments);
                                ?>

                                <?php foreach ($coments as $coment): ?>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Аватар</th>
                                            <th>Имя</th>
                                            <th>Дата</th>
                                            <th>Комментарий</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>

                                                <img src="<?php echo 'img/'. basename($coment['image'])?>" alt="" class="img-fluid" width="64" height="64">

                                            </td>
                                            <td><?php  echo $coment['user_name'] ?></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($coment['date']))?></td>
                                            <td><?php  echo $coment['coment'] ?></td>
                                            <td>

                                                <?php if ($coment['status'] == 0): ?>
                                                    <a href="/app/include/check_admin_allow.php?coment_id=<?php echo $coment['id'] ?>&user_id=<?php echo  $_SESSION['user_id']?>" class="btn btn-success">Разрешить</a>
                                                        <?php endif; ?>

                                                <?php if ($coment['status'] == 1): ?>
                                                   <a href="/app/include/check_admin_forbid.php?coment_id=<?php echo $coment['id'] ?>&user_id=<?php echo  $_SESSION['user_id']?>" class="btn btn-warning">Запретить</a>
                                                       <?php endif; ?>

                                                    <a href="/app/include/check_admin_delete.php?coment_id=<?php echo $coment['id']?>&user_id=<?php echo  $_SESSION['user_id']?>" onclick="return confirm('are you sure?')" class="btn btn-danger">Удалить</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
