<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

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
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">Login

                                <span style="color: red">
                                <?php
                                     echo $_SESSION['feild_login_ver'];
                                          unset($_SESSION['feild_login_ver']);
                                     echo $_SESSION['notice_password_ver'];
                                          unset($_SESSION['notice_password_ver']);
                                     echo $_SESSION['warning'];
                                          unset( $_SESSION['warning']);
                                     echo $_SESSION['error_messages'];
                                          unset($_SESSION['error_messages']);
                                     echo $_SESSION['error_select_db'];
                                          unset($_SESSION['error_select_db']);
                                 ?>
                                </span>

                            </div>

                            <div class="card-body">
                                <form method="POST" action="app/include/check_login.php">

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                        <div class="col-md-6">
                                            <input id="email" type="" class="form-control is-invalid " name="email"  autocomplete="email" autofocus >
                                                <span class="" role="alert" style="color:red">
                                                    <?php
                                                          echo $_SESSION['notice_email'];
                                                               unset($_SESSION['notice_email']);
                                                          echo $_SESSION['notice_email_verify'];
                                                               unset($_SESSION['notice_email_verify']);
                                                          echo $_SESSION['login_email_coincidence'];
                                                               unset($_SESSION['login_email_coincidence']);
                                                          ?>
                                                </span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control" name="password"  autocomplete="current-password">
                                            <span style="color:red">
                                                <?php
                                                      echo $_SESSION['notice_pasword'];
                                                           unset($_SESSION['notice_pasword']);
                                                      //echo $_SESSION['notice_password_ver'];
                                                      //     unset($_SESSION['notice_password_ver']);
                                                ?></span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" >

                                                <label class="form-check-label" for="remember">
                                                    Remember Me
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                               Login
                                            </button>
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
