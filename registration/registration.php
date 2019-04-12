<html>
    <!-- This snippet uses Font Awesome 5 Free as a dependency. You can download it at fontawesome.io! -->

    <header>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

        <link href="../css/new-age.css" rel="stylesheet">
        <link rel="stylesheet" href="registration.css">
        <link rel="stylesheet" href="../navbar.css">
    </header>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="../index.html">
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
              <a class="nav-link js-scroll-trigger" href="../registration/registration.php">Sign Up</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="../login/login.php">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <body>
    <div class="container">
    <div class="row">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card card-signin flex-row my-5">
          <div class="card-img-left d-none d-md-flex">
             <!-- Background image for card set in CSS! -->
          </div>
          <div class="card-body">
            <h5 class="card-title text-center">Register</h5>
            <form class="form-signin">
              <div class="form-label-group">
                <input type="text" id="inputUserame" class="form-control" placeholder="Username" required autofocus>
                <label for="inputUserame">Username</label>
              </div>

              <div class="form-label-group">
                <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required>
                <label for="inputEmail">Email address</label>
              </div>

              <hr>

              <div class="form-label-group">
                <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
              </div>

              <div class="form-label-group">
                <input type="password" id="inputConfirmPassword" class="form-control" placeholder="Password" required>
                <label for="inputConfirmPassword">Confirm password</label>
              </div>

              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Register</button>
              <a class="d-block text-center mt-2 small sign-in-redirect" href="../login/login.php">Sign In</a>
              <hr class="my-4">
              <!--
              <button class="btn btn-lg btn-google btn-block text-uppercase" type="submit" formnovalidate><i class="fab fa-google mr-2"></i> Sign up with Google</button>
              <button class="btn btn-lg btn-facebook btn-block text-uppercase" type="submit" formnovalidate><i class="fab fa-facebook-f mr-2"></i> Sign up with Facebook</button>
              -->
            </form>
          </div>
        </div>
      </div>
    </div>
    </div>
    </body>

</html>
