<?php
    require("createSession.php");


?>
<html>

    <header>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

        <link href="../css/new-age.css" rel="stylesheet">
        <link rel="stylesheet" href="../navbar.css">
        <link rel="stylesheet" href="login.css">

    </header>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="../index.php">
          <picture>
            <source media="(min-width: 480px)" srcset="../pics/icon.png">
            <source media="(max-width: 480px)" srcset="../pics/white-icon.png">
            <img class="navbar-brand" src="../pics/icon.png" alt="IfItDoesntMatchAnyMedia">
          </picture>
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="../register/register.php">Sign Up</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="../login/login.php">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <br><br><br>

    <body>
    <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Sign In</h5>
            <form class="form-sigin" action="login.php" method="post">
              <div class="form-label-group">
                <input type="username" id="inputUsername" name="username" class="form-control" required autofocus>
                <label for="inputUsername">Username</label>
              </div>

              <div class="form-label-group">
                <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
              </div>

              <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Remember password</label>
              </div>
              <input type="submit" name="loginButton" class="btn btn-lg btn-primary btn-block text-uppercase" value="Login">
              <hr class="my-4">
              <!--<button class="btn btn-lg btn-google btn-block text-uppercase" type="submit" formnovalidate><i class="fab fa-google mr-2"></i> Sign in with Google</button>-->
              <button class="btn btn-lg btn-facebook btn-block text-uppercase" type="submit" formnovalidate><i class="fab fa-facebook-f mr-2"></i> Sign in with Facebook</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    </div>
    </body>
</html>
