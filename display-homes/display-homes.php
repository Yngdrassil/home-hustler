<?php
    require('api-calls.php');
 ?>

<html>

    <header>
        <title>Home Hustler</title>

        <!--Responsive Meta Tag-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <!--Import Google Icon Font-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <!--Import materialize.css-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
        <!--Import jQuery Library-->

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
              <a class="nav-link js-scroll-trigger" href="../register/register.php">Sign Up</a>
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
              <form class="sort-filter" name="sortAndFilter">
                    <div class="form-label-group sort">
                      <br><br><br><br>
                      <label class="unselectable sidebar-header" for="sort">Sort By</label>
                      <select id="sortHouses" onchange="callOrderListings()">
                          <option value="total-monthly-cost">Total Monthly Cost</option>
                          <option value="commute-cost">Commute Cost</option>
                          <option value="commute-distance">Commute Distance</option>
                          <option value="listing-price" selected="selected">Listing Price</option>
                          <option value="square-feet">Square Feet</option>
                      </select>
                      <br><br>
                      <label class="unselectable sidebar-header" for="order">Order</label>

                      <div class="form-group">

                          <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="ascending" name="order" value="ascending" checked onchange="callOrderListings()">
                            <label class="custom-control-label" for="ascending">Ascending</label>
                          </div>

                          <div class="custom-control custom-radio">
                            <input type="radio" class="custom-control-input" id="descending" name="order" value="descending" onchange="callOrderListings()">
                            <label class="custom-control-label" for="descending">Descending</label>
                          </div>
                      </div>

                    </div>

                    <hr>

                    <div class="form-label-group filter">
                        <label class="unselectable sidebar-header" for="filter">Filter</label>

                        <div class="form-label-group">
                          <label class="unselectable" for="monthly-cost-filter">Max Monthly Cost</label>
                          <input type="text" name="monthly-cost-filter" id="monthly-cost-filter" class="form-control">
                        </div>

                        <div class="form-label-group">
                          <label class="unselectable" for="commute-cost-filter">Max Commute Cost</label>
                          <input type="text" name="commute-cost-filter" id="commute-cost-filter" class="form-control">
                        </div>

                        <div class="form-label-group">
                          <label class="unselectable" for="commute-distance-filter">Max Commute Distance</label>
                          <input type="text" name="commute-distance-filter" id="commute-distance-filter" class="form-control">
                        </div>

                        <div class="form-label-group">
                          <label class="unselectable" for="listed-price-filter">Max Listed Price</label>
                          <input type="text" name="listed-price-filter" id="listed-price-filter" class="form-control">
                        </div>

                        <div class="form-label-group">
                          <label class="unselectable" for="square-footage-filter">Minimum Square Footage</label>
                          <input type="text" name="square-footage-filter" id="square-footage-filter" class="form-control">
                        </div>
                    </div>
                    <div><button type="button" class="btn btn-primary" id="filters" onclick="callOrderListings()">Apply Filters</button></div>
                </form>
            </div>

            <div class="col-sm-10 offset-sm-0" id="Listings">
                <div class="container table-responsive">
                  <br><br><br><br>
                    <table class="table">
                        <tbody>
                            <?php
                                applyOrder();
                                function applyOrder()
                                {
                                  //echo file_get_contents("9-cube-grid.html");
                                  $near = $_POST['state'];
                                  if(!empty($_POST['zipcode'])) {
                                      $near = $_POST['zipcode'];
                                  }
                                  $budget = $_POST['budget'];
                                  $address = $_POST['address'];
                                  $city = $_POST['city'];
                                  $state = $_POST['state'];
                                  $zipcode = $_POST['zipcode'];
                                  echo "
                                    <script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js\"></script>
                                    <script type=\"text/javascript\">
                                    callOrderListings();
                                    function callOrderListings()
                                    {
                                      $.ajax({ url: 'http://localhost:8080/home-hustler/display-homes/api-calls.php',
                                               data: {spinner: 'yes'},
                                               dataType: \"html\",
                                               type: 'post',
                                               success: function(output) {
                                                            document.getElementById(\"Listings\").innerHTML = \"\";
                                                            document.getElementById(\"Listings\").innerHTML = \"<br><br><br><br><br><br><thead><center> Housing List </center></thead><br><br><br>\" + output;
                                              }
                                      });
                                      var e = document.getElementById(\"sortHouses\");
                                      var strUser = e.options[e.selectedIndex].value;

                                      var maxMonthlyCost=document.getElementById('monthly-cost-filter').value;
                                      var maxCommuteCost=document.getElementById('commute-cost-filter').value;
                                      var maxCommuteDistance=document.getElementById('commute-distance-filter').value;
                                      var maxListedPrice=document.getElementById('listed-price-filter').value;
                                      var minSquareFootage=document.getElementById('square-footage-filter').value;

                                      if (document.getElementById('ascending').checked && document.getElementById('ascending').value==\"ascending\")
                                      {
                                          orderListings(strUser,maxMonthlyCost,maxCommuteCost,maxCommuteDistance,maxListedPrice,minSquareFootage);
                                      }
                                      if (document.getElementById('descending').checked && document.getElementById('descending').value==\"descending\")
                                      {
                                        orderListings(\"r\" + strUser,maxMonthlyCost,maxCommuteCost,maxCommuteDistance,maxListedPrice,minSquareFootage);
                                      }
                                    }
                                    function orderListings(strUser,maxMonthlyCost,maxCommuteCost,maxCommuteDistance,maxListedPrice,minSquareFootage)
                                    {
                                      $.ajax({ url: 'http://localhost:8080/home-hustler/display-homes/api-calls.php',
                                               data: {function2call: 'parseListings',
                                                      state: \"$state\",
                                                      budget: \"$budget\",
                                                      address: \"$address\",
                                                      city: \"$city\",
                                                      zipcode: \"$zipcode\",
                                                      option: strUser,
                                                      maxMonthlyCost: maxMonthlyCost,
                                                      maxCommuteCost: maxCommuteCost,
                                                      maxCommuteDistance: maxCommuteDistance,
                                                      maxListedPrice: maxListedPrice,
                                                      minSquareFootage: minSquareFootage
                                                      },
                                               dataType: \"html\",
                                               type: 'post',
                                               success: function(output) {
                                                            document.getElementById(\"Listings\").innerHTML = \"\";
                                                            document.getElementById(\"Listings\").innerHTML = \"<br><br><br><br><br><br><thead><center> Housing List </center></thead><br><br><br>\" + output;
                                              }
                                      });
                                    }
                                  </script>";
                                }                    // AJAX URL FOR LIVE SITE = http://www.home-hustler.com/display-homes/api-calls.php     http://localhost:8080/home-hustler/display-homes/api-calls.php
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</html>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<!--Import materialize.js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
