<?php
    require("session_functions.php");
?>
<html lang="en">

    <head>

      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta name="description" content="Optimized Housing Search Engine">
      <meta name="author" content="Blake Edens, Mattia Galanti, Waylon Ergle">

      <title>Home Hustler</title>


      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.bundle.min.js">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

      <!-- Custom fonts for this template -->
      <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.css">
      <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Catamaran:100,200,300,400,500,600,700,800,900" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css?family=Muli" rel="stylesheet">

      <!-- Custom styles for this template -->
      <link href="css/new-age.css" rel="stylesheet">

    </head>

    <body id="page-top">

      <!-- Navigation -->
      <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
          <a class="js-scroll-trigger" href="#page-top">
              <picture>
                <source media="(min-width: 480px)" srcset="pics/icon.png">
                <source media="(max-width: 480px)" srcset="pics/white-icon.png">
                <img class="navbar-brand" src="pics/icon.png" alt="IfItDoesntMatchAnyMedia">
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
              <?php isLoggedIn() ?>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <form action="display-homes/display-homes.php" method="post" class="search-parameters">
          <header class="masthead">

              <div class="container h-100">
                <div class="row">

                  <div class="col-lg-5">
                      <p class="mb-5">
                          Find the right house for your budget.
                      </p>
                  </div>

                  <div class="col-lg-4 offset-lg-3 my-auto">
                        <div class="form-label-group">
                          <label class="unselectable" for="address">Work Address</label>
                          <input type="text" name="address" class="form-control w-75" placeholder="Required" required autofocus>
                        </div>

                        <div class="d-flex align-items-center">

                            <div class="form-label-group">
                              <label class="unselectable" for="city">City</label>
                              <input type="text" name="city" class="form-control" placeholder="Required" required>
                            </div>

                            <div class="form-label-group">
                              <label class="unselectable mt-auto" for="state">State</label>
                              <select name="state" class="custom-select offset-2 rounded mb-auto p-2 w-50">
                                <option value="AL">AL</option>
                              	<option value="AK">AK</option>
                              	<option value="AR">AR</option>
                              	<option value="AZ">AZ</option>
                              	<option value="CA">CA</option>
                              	<option value="CO">CO</option>
                              	<option value="CT">CT</option>
                              	<option value="DC">DC</option>
                              	<option value="DE">DE</option>
                              	<option value="FL">FL</option>
                              	<option value="GA">GA</option>
                              	<option value="HI">HI</option>
                              	<option value="IA">IA</option>
                              	<option value="ID">ID</option>
                              	<option value="IL">IL</option>
                              	<option value="IN">IN</option>
                              	<option value="KS">KS</option>
                              	<option value="KY">KY</option>
                              	<option value="LA">LA</option>
                              	<option value="MA">MA</option>
                              	<option value="MD">MD</option>
                              	<option value="ME">ME</option>
                              	<option value="MI">MI</option>
                              	<option value="MN">MN</option>
                              	<option value="MO">MO</option>
                              	<option value="MS">MS</option>
                              	<option value="MT">MT</option>
                              	<option value="NC">NC</option>
                              	<option value="NE">NE</option>
                              	<option value="NH">NH</option>
                              	<option value="NJ">NJ</option>
                              	<option value="NM">NM</option>
                              	<option value="NV">NV</option>
                              	<option value="NY">NY</option>
                              	<option value="ND">ND</option>
                              	<option value="OH">OH</option>
                              	<option value="OK">OK</option>
                              	<option value="OR">OR</option>
                              	<option value="PA">PA</option>
                              	<option value="RI">RI</option>
                              	<option value="SC">SC</option>
                              	<option value="SD">SD</option>
                              	<option value="TN">TN</option>
                              	<option value="TX">TX</option>
                              	<option value="UT">UT</option>
                              	<option value="VT">VT</option>
                              	<option value="VA">VA</option>
                              	<option value="WA">WA</option>
                              	<option value="WI">WI</option>
                              	<option value="WV">WV</option>
                              	<option value="WY">WY</option>
                              </select>
                            </div>

                        </div>

                            <div class="form-label-group">
                              <label class="unselectable" for="zipcode">Zipcode</label>
                              <input type="text" name="zipcode" class="form-control" placeholder="Preferred">
                            </div>

                        <div class="form-label-group">
                          <label class="unselectable" for="budget">Budget</label>
                          <input type="text" name="budget" class="form-control" placeholder="Required" required>
                        </div>

                        <div class="form-label-group">
                          <label class="unselectable" for="inputVehicleMPG">Vehicle MPG</label>
                          <input type="text" name="inputVehicleMPG" class="form-control" placeholder="Optional">
                        </div>

                        <div class="form-label-group">
                          <label class="unselectable" for="inputWage">Wage</label>
                          <input type="text" name="inputWage" class="form-control" placeholder="Optional">
                        </div>


                            <center><input type="submit" class="btn btn-outline btn-xl js-scroll-trigger" value="Search" name="search-button"></center>
                  </div>
                </div>
              </div>

          </header>

          <section class="advanced-search" id="advanced-search">
            <div class="container-fluid">
                <div class="row">
                  <div class="offset-lg-2 col-lg-3 offset-lg-1 my-auto">
                            <div class="form-label-group">
                              <label class="unselectable" for="maxCommuteDistance">Maximum Commute Distance</label>
                              <input type="text" name="maxCommuteDistance" class="form-control">
                            </div>

                            <div class="form-label-group">
                              <label class="unselectable" for="minSquareFeet">Minimum Square Feet</label>
                              <input type="text" name="minSquareFeet" class="form-control">
                            </div>

                            <div class="form-label-group">
                              <label class="unselectable" for="minLotSize">Minimum Lot Size</label>
                              <input type="text" name="minLotSize" class="form-control">
                            </div>
                  </div>

                  <div class="offset-lg-1 col-lg-3 offset-lg-2 my-auto">
                            <div class="form-label-group">
                              <label class="unselectable" for="minBedrooms">Minimum Bedrooms</label>
                              <input type="text" name="minBedrooms" class="form-control">
                            </div>

                            <div class="form-label-group">
                              <label class="unselectable" for="minBathrooms">Minimum Bathrooms</label>
                              <input type="text" name="minBathrooms" class="form-control">
                            </div>

                            <div class="form-label-group">
                              <label class="unselectable" for="maxHomeAge">Maximum Home Age</label>
                              <input type="text" name="maxHomeAge" class="form-control">
                            </div>
                  </div>
                </div>
                <center><input type="submit" class="btn btn-outline btn-xl js-scroll-trigger" value="Advanced Search" name="search-button"></center>
            </div>
          </section>
      </form>

      <section class="contact bg-primary" id="contact">
        <div class="container">
          <h2>We
            <i class="fas fa-heart"></i>
            new friends!</h2>
          <ul class="list-inline list-social">
            <li class="list-inline-item social-twitter">
              <a href="#">
                <i class="fab fa-twitter"></i>
              </a>
            </li>
            <li class="list-inline-item social-facebook">
              <a href="#">
                <i class="fab fa-facebook-f"></i>
              </a>
            </li>
            <li class="list-inline-item social-google-plus">
              <a href="#">
                <i class="fab fa-google-plus-g"></i>
              </a>
            </li>
          </ul>
        </div>
      </section>

      <footer>
        <div class="container">
          <p>&copy; Home Hustler 2019. All Rights Reserved.</p>
          <ul class="list-inline">
            <li class="list-inline-item">
              <a href="#">Privacy</a>
            </li>
            <li class="list-inline-item">
              <a href="#">Terms</a>
            </li>
            <li class="list-inline-item">
              <a href="#">FAQ</a>
            </li>
          </ul>
        </div>
      </footer>

      <!-- Bootstrap core JavaScript -->
      <script src="vendor/jquery/jquery.min.js"></script>
      <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

      <!-- Plugin JavaScript -->
      <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

      <!-- Custom scripts for this template -->
      <script src="js/new-age.min.js"></script>

      <!-- FontAwesome CDN -->
      <script src="https://use.fontawesome.com/1c45cd7ea9.js"></script>

    </body>

</html>
