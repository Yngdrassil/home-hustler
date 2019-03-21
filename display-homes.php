<?php
    require('api-calls.php');
 ?>

<html>

    <header>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

        <!-- Custom fonts for this template -->
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../vendor/simple-line-icons/css/simple-line-icons.css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

        <link href="display-homes.css" rel="stylesheet">
        <link href="../navbar.css" rel="stylesheet">
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

    <div class="container-fluid display">
        <div class="row">
            <div class="col-sm-2">
              <form class="sort-filter">
                    <div class="form-label-group sort">
                      <label class="unselectable sidebar-header" for="sort">Sort By</label>
                      <select>
                          <option value="total-monthly-cost">Total Monthly Cost</option>
                          <option value="commute-cost">Commute Cost</option>
                          <option value="commute-distance">Commute Distance</option>
                          <option value="listing-price">Listing Price</option>
                          <option value="square-feet">Square Feet</option>
                      </select>

                      <label class="unselectable sidebar-header" for="order">Order</label>

                      <div class="form-group">

                          <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="ascending" name="ascending" checked>
                            <label class="custom-control-label" for="descending">Ascending</label>
                          </div>

                          <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="descending" name="descending">
                            <label class="custom-control-label" for="descending">Descending</label>
                          </div>
                      </div>

                    </div>

                    <hr>

                    <div class=" form-label-group filter">
                        <label class="unselectable sidebar-header" for="filter">Filter</label>

                        <div class="form-label-group">
                          <label class="unselectable" for="monthly-cost-filter">Max Monthly Cost</label>
                          <input type="text" name="monthly-cost-filter" class="form-control">
                        </div>

                        <div class="form-label-group">
                          <label class="unselectable" for="commute-cost-filter">Max Commute Cost</label>
                          <input type="text" name="commute-cost-filter" class="form-control">
                        </div>

                        <div class="form-label-group">
                          <label class="unselectable" for="commute-distance-filter">Max Commute Distance</label>
                          <input type="text" name="commute-distance-filter" class="form-control">
                        </div>

                        <div class="form-label-group">
                          <label class="unselectable" for="listed-price-filter">Listed Price</label>
                          <input type="text" name="listed-price-filter" class="form-control">
                        </div>

                        <div class="form-label-group">
                          <label class="unselectable" for="square-footage-filter">Minimum Square Footage</label>
                          <input type="text" name="square-footage-filter" class="form-control">
                        </div>
                    </div>

                </form>
            </div>

            <div class="col-sm-8 offset-sm-1">

                    <div class="container table-responsive">
                      <br><br><br><br>
                        <table class="table">
                            <thead><center> Housing List </center></thead>
                            <tbody>
                                <?php parseListings(); ?>
                            </tbody>
                        </table>
                      </div>

            </div>
        </div>
    </div>

</html>
