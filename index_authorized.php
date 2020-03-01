<?php
session_start();
?>
<?php

if(!isset($_COOKIE["password_cookie_token"]) && empty($_COOKIE["password_cookie_token"]) && !isset($_SESSION["user_name"])){
    header("Location:/login.php");
}

require_once 'app/include/database.php';
require_once 'app/include/functions.php';


if(isset($_COOKIE["password_cookie_token"]) && !empty($_COOKIE["password_cookie_token"])) {

    $query = "SELECT * FROM `users` WHERE password_cookie_token = '".$_COOKIE["password_cookie_token"]."'";
    $result = mysqli_query($link, $query);
    $select_user_data = mysqli_fetch_assoc($result);


    if(!$select_user_data){
        $_SESSION['error_select_db'] = "Ошибка выборки БД";
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

    <?php require_once 'app/include/database.php' ?>
    <?php require_once 'app/include/functions.php' ?>


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

                    </div>
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
                                <a></a>
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
                            <div class="card-header"><h3>Комментарии</h3></div>

                            <div class="card-body">
                              <div class="alert alert-success" role="alert">
                                  <?php
                                       echo $_SESSION['notice_coment'];
                                       unset($_SESSION['notice_coment']);
                                  ?>
                              </div>

                                <!----------------------------------------------- Начало коментариев ---------------------------------------------------------->

                    <?php
                          $coments = get_coments($link);

                    ?>

				    <?php foreach ($coments as $coment): ?>
                    <?php if($coment['status'] == 1): ?>

                                <div class="media">
                                  <img src="<?php echo 'img/'. basename($coment['image'])?>" class="mr-3" alt="..." width="64" height="64">
                                  <div class="media-body">
                                    <h5 class="mt-0">
                                                 <?php  echo $coment['user_name'] ?>
                                    </h5>
                                    <span><small><?php echo date('d/m/Y H:i', strtotime($coment['date']))?></small></span>
                                    <p>
                                                 <?php  echo $coment['coment'] ?>
                                    </p>
                                  </div>
                                </div>

                        <?php endif; ?>
                    <?php endforeach; ?>

                                <!----------------------------------------------- Конец коментариев ---------------------------------------------------------->

                            </div>
                        </div>
                    </div>
                
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="card">
                            <div class="card-header"><h3>Оставить комментарий</h3></div>

                            <div class="card-body">
                                <form action="app/include/check_coment_authorized.php" method="post">

                                  <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Сообщение</label>
                                    <textarea name="text" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                      <span  style="color:red">
                                      <?php
                                           echo  $_SESSION['notice_text'];
                                           unset($_SESSION['notice_text']);
                                           //session_destroy();
                                      ?>
                                      </span>
                                  </div>
                                  <button type="submit" class="btn btn-success">Отправить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
