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
            $_SESSION['user_email'] = $array_user_data["email"];
            $_SESSION['image'] =  $array_user_data["image"];
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
                        <div class="card-header"><h3>Профиль пользователя</h3></div>

                        <div class="card-body">
                          <div class="alert alert-success" role="alert">
                              <?php echo $_SESSION['success'];
                                    unset ($_SESSION['success']);
                               ?>
                          </div>

                            <form method="POST" action="app/include/check_profile2.php" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Name</label>
                                            <input type="text" class="form-control" name="name" id="exampleFormControlInput1" value="<?php echo $_SESSION['user_name']?>">
                                            <span style="color: red">
                                                <?php
                                                     echo $_SESSION['error_name'];
                                                     unset($_SESSION['error_name']);
                                                ?>

                                                </span>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Email</label>
                                            <input type="" class="form-control" name="email" id="exampleFormControlInput1" value="<?php echo $_SESSION['email']?>">
                                            <span style="color: red">
                                               <?php
                                                    echo $_SESSION['error_email'];
                                                    unset($_SESSION['error_email']);
                                                    echo $_SESSION['error_email_verify'];
                                                    unset($_SESSION['error_email_verify']);
                                                    echo $_SESSION['login_email_coincidence'];
                                                    unset($_SESSION['login_email_coincidence']);
                                               ?>
                                            </span>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Аватар</label>
                                            <input type="file" class="form-control" name="image" id="exampleFormControlInput1">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <img src=" <?php echo 'img/'. basename($_SESSION['image'])?>" alt="" class="img-fluid">
                                    </div>

                                    <div class="col-md-12">
                                        <button class="btn btn-warning">Edit profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="margin-top: 20px;">
                    <div class="card">
                        <div class="card-header"><h3>Безопасность</h3></div>

                        <div class="card-body">
                            <div class="alert alert-success" role="alert">
                                <span class="red">
                                <?php
                                     echo $_SESSION['pass_update_success'];
                                     unset($_SESSION['pass_update_success']);
                                ?>
                                </span>
                            </div>

                            <form action="app/include/check_profile_pass.php" method="post">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Current password</label>
                                            <input type="password" name="current_pass"  class="form-control" id="exampleFormControlInput1">
                                            <span style="color: red">
                                            <?php
                                                  echo $_SESSION['error_current_pass'];
                                                  unset ($_SESSION['error_current_pass']);
                                                  echo $_SESSION['error_current_pass_ver'];
                                                  unset($_SESSION['error_current_pass_ver']);
                                            ?>
                                            </span>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">New password</label>
                                            <input type="password" name="password" class="form-control" id="exampleFormControlInput1">
                                            <span style="color: red">
                                             <?php
                                                  echo $_SESSION['error_password'];
                                                  unset($_SESSION['error_password']);
                                                  echo $_SESSION['error_password_length'];
                                                  unset ($_SESSION['error_password_length']);
                                                  //echo $_SESSION['error_password_equal'];
                                                  //unset($_SESSION['error_password_equal']);
                                             ?>
                                            </span>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlInput1">Password confirmation</label>
                                            <input type="password" name="password_confirmation" class="form-control" id="exampleFormControlInput1">
                                            <span style="color: red">
                                            <?php echo $_SESSION['error_password_confirmation'];
                                                  unset ($_SESSION['error_password_confirmation']);
                                                  echo $_SESSION['error_password_equal'];
                                                  unset($_SESSION['error_password_equal']);
                                            ?>
                                            </span>
                                        </div>

                                        <button class="btn btn-success">Submit</button>
                                    </div>
                                </div>
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
