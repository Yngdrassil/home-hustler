<?php
    require_once("../vendor/autoload.php");
    require_once("googleCalls.php");
    require_once("utilityPrices.php");
    require_once("gasPrices.php");
    require_once("moneyFormat.php");
    require_once("fedData.php");

    //there you go
    $attom_api_key = 'a38f76c6891995290466517ef9c81623';

    if(isset($_POST['function2call']))
    {
      $residentialListings = reso_call();

      if(!empty($residentialListings)) {
          foreach($residentialListings as $bundle) {
            $listingPrice = $bundle->ListPrice;

                        $monthly_tax_cost = $listingPrice * 0.01188 / 12;              //use property tax value of San Francisco for demo

            $address = $bundle->StreetNumber . " " . $bundle->StreetDirPrefix . " " . $bundle->StreetName . " " . $bundle->StreetSuffix;
            $city = $bundle->City;
            $state = $bundle->StateOrProvince;
            $zipcode = $bundle->PostalCode;

            $bedrooms = $bundle->BedroomsTotal;
            $bathrooms = $bundle->BathroomsTotalDecimal;
            $squareFeet = $bundle->LivingArea;
            $lotSize = $bundle->LotSizeAcres;
            $yearBuilt = $bundle->YearBuilt;
            $utilities = $bundle->Utilities;

            $commuteDistanceTime = googleDistanceMatrix($address, $city, $state, $zipcode);   //Get commute distance and time
            $distance = $commuteDistanceTime['distance'];
            $time = $commuteDistanceTime['time'];
            $commuteCost = 2 * ($distance / $mpg) * getGasPrice($state);    //Calculate commute cost (to and from work location)

            $hours = getHoursFromTime($time);
            $wageLoss = round($hours * $wage, 2);
            $commuteCost += $wageLoss;

            $monthlyCommute = $commuteCost * 350 / 12;                     //Annualize by 50 weeks of work per year, then divide into months



            $electricityCost = 0;
            if(hasElectricity($utilities)) {
                $monthlyElectricityCost = monthlyElectricityCost($state, $squareFeet);
            }

            $naturalGasCost = 0;
            if(hasElectricity($utilities)) {
                $monthlyNaturalGasCost = monthlyNaturalGasCost($state, $squareFeet);
            }

            $mortgageRate = get30YrFixedMortgageRate() / 12;                          //turn into monthly rate

            $mortgageNumerator = $mortgageRate * (pow((1 + $mortgageRate), 30 * 12));   //period = 30 years, every month
            $mortgageDenominator = (pow((1 + $mortgageRate), 30 * 12)) - 1;

            $monthlyMortgageCost = $listingPrice * ($mortgageNumerator / $mortgageDenominator);

            $aggregateMonthlyCost = round((double)$monthlyCommute +
                                          (double)$monthlyElectricityCost +
                                          (double)$monthlyNaturalGasCost +
                                          (double)$monthly_tax_cost +
                                          (double)$monthlyMortgageCost, 0);

            $bundle->monthlyTaxCost = $monthly_tax_cost;
            $bundle->commuteDistance = $distance;
            $bundle->commuteTime = $time;
            $bundle->monthlyCommuteCost = $monthlyCommute;
            $bundle->monthlyElectricityCost = $monthlyElectricityCost;
            $bundle->monthlyNaturalGasCost = $monthlyNaturalGasCost;
            $bundle->monthlyMortgageCost = $monthlyMortgageCost;
            $bundle->aggregateMonthlyCost = $aggregateMonthlyCost;                 //add total monthly cost to the JSON object for filtering

          }
      }

      if($_POST['maxMonthlyCost']!="")
      {
        foreach($residentialListings as $bundle)
        {
          if(($bundle->TaxAnnualAmount)>$_POST['maxMonthlyCost'])
            unset($residentialListings[$bundle]);
        }
      }
      if($_POST['maxCommuteCost']!="")
      {

      }
      if($_POST['maxCommuteDistance']!="")
      {
        foreach($residentialListings as $bundle=>$element)
        {
          $address = $element->StreetNumber . " " . $element->StreetDirPrefix . " " . $element->StreetName . " " . $element->StreetSuffix;
          $city = $element->City;
          $state = $element->StateOrProvince;
          $zipcode = $element->PostalCode;
          $commuteDistanceTime = googleDistanceMatrix($address, $city, $state, $zipcode);
          $distance = $commuteDistanceTime['distance'];
          if($distance>$_POST['maxCommuteDistance'])
            unset($residentialListings[$bundle]);
        }
      }
      if($_POST['maxListedPrice']!="")
      {
        foreach($residentialListings as $bundle=>$element)
        {
          if($element->ListPrice>$_POST['maxListedPrice'])
            unset($residentialListings[$bundle]);
        }
      }
      if($_POST['minSquareFootage']!="")
      {
        foreach($residentialListings as $bundle=>$element)
        {
          if($element->LivingArea<$_POST['maxListedPrice'])
            unset($residentialListings[$bundle]);
        }
      }
      if($_POST['option']=='square-feet')
        sortListings("sortBySquareFeet");
      if($_POST['option']=='total-monthly-cost')
        sortListings("sortByTotalMonthlyCost");
      if($_POST['option']=='listing-price')
        sortListings("sortByListingPrice");
      if($_POST['option']=='commute-distance')
        sortListings("sortByCommuteDistance");
      if($_POST['option']=='rsquare-feet')
        sortListings("reverseSortBySquareFeet");
      if($_POST['option']=='rtotal-monthly-cost')
        sortListings("reverseSortByTotalMonthlyCost");
      if($_POST['option']=='rlisting-price')
        sortListings("reverseSortByListingPrice");
      if($_POST['option']=='rcommute-distance')
        sortListings("reverseSortByCommuteDistance");
      parseListings();
    }

    function reso_call() {

        //API DOCUMENTATION  ->  https://rets.ly/docs/explorer/Property
        $dataset = 'test_sf';    //currently using San Francisco dataset
        $access_token = '626af6da8489a7d2710d55f37619851c';
        $fields = 'StreetNumber,StreetDirPrefix,StreetName,StreetSuffix,City,StateOrProvince,PostalCode,Media,ListPrice,TaxAnnualAmount,InsuranceExpense,PropertyType,Utilities,LivingArea,LotSizeAcres,BedroomsTotal,BathroomsTotalDecimal,YearBuilt';
        $limit = 30;

        $near = $_POST['state'];
        if(!empty($_POST['zipcode'])) {
            $near = $_POST['zipcode'];
        }

        $radius = 500;   //get range from advanced search

        //listing details such as price, square feet, lot size, bedrooms, bathrooms, year built, etc.
        $listing_details_url = "https://api.bridgedataoutput.com/api/v2/$dataset/listings?access_token=$access_token&fields=$fields&limit=$limit&near=$near&radius=$radius";

        //get JSON contents
        $result = @file_get_contents($listing_details_url);

        // Convert JSON string to Object
        $listings = json_decode($result);

        if (!empty($result)) {
            // Filter for capturing only residential listings within budget
            $budget = $_POST['budget'];
            $residentialListings = array();
            foreach($listings->bundle as $key => $value) {
                if ($listings->bundle[$key]->PropertyType == 'Residential') { //only get residential properties
                    if ($listings->bundle[$key]->ListPrice <= $budget) {      //test if within budget

                        if (isset($listings->bundle[$key]->Media[0])) {
                            $media = $listings->bundle[$key]->Media[0]->MediaURL;
                            $listings->bundle[$key]->MediaURL = $media;
                        }

                      $residential = $listings->bundle[$key];
                      array_push($residentialListings, $residential);
                    }
                }
            }
        }
        else {
            echo "<br><br><br><tr><hr><hr><br><center>No Results Found</center><hr></tr><hr>";
        }
        //returns an array of JSON objects
        if (isset($residentialListings)) {
            return $residentialListings;
        }
        else {
            return array();
        }

    }

    function parseListings() {

        global $residentialListings;

        //calculate commuting cost
        if (isset($_POST['inputVehicleMPG'])) {
          $mpg = $_POST['inputVehicleMPG'];             //get mpg for commuting cost estimate
        }
        else {
          $mpg = 24.7;                                  //average mpg used if not provided
        }

        if(isset($_POST['inputWage'])) {
            $wage = $_POST['inputWage'];                //get wage if set
        }
        else {
            $wage = 0;                                  //otherwise do not factor into commute cost
        }

        foreach($residentialListings as $bundle) {
            $listingPrice = $bundle->ListPrice;

            //$monthly_tax_cost = $bundle->TaxAnnualAmount/ 12.0 / 100;    //divide by another 100 to adjust erroneous test data
            $monthly_tax_cost = $listingPrice * 0.01188 / 12;              //use property tax value of San Francisco for demo

            $address = $bundle->StreetNumber . " " . $bundle->StreetDirPrefix . " " . $bundle->StreetName . " " . $bundle->StreetSuffix;
            $city = $bundle->City;
            $state = $bundle->StateOrProvince;
            $zipcode = $bundle->PostalCode;

            $bedrooms = $bundle->BedroomsTotal;
            $bathrooms = $bundle->BathroomsTotalDecimal;
            $squareFeet = $bundle->LivingArea;
            $lotSize = $bundle->LotSizeAcres;
            $yearBuilt = $bundle->YearBuilt;
            $utilities = $bundle->Utilities;

            if (isset($bundle->MediaURL)) {   //use RESO image if provided
                $image = $bundle->MediaURL;
            }
            else {                            //otherwise use Google Streetview image
                $image = googleStreetImage($address, $city, $state, $zipcode);
            }


            $listingPrice = toMoney($listingPrice);
            $monthly_tax_cost = toMoney($monthly_tax_cost);
            $commuteCost = toMoney($commuteCost);
            $monthlyCommute = toMoney($monthlyCommute);
            $monthlyElectricityCost = toMoney($monthlyElectricityCost);
            $monthlyNaturalGasCost = toMoney($monthlyNaturalGasCost);
            $monthlyMortgageCost = toMoney($monthlyMortgageCost);
            $aggregateMonthlyCost = toMoney($aggregateMonthlyCost);

            echo "
            <!DOCTYPE html>
            <html>
            <body>
            <style type=\"text/css\">
            	.m20_0{ margin:10px 0px;}
            </style>
            <div class=\"m20	_0\">
            	<div class=\"col s13 m6 l6\">
                    <div class=\"card\">
                        <div class=\"card-image waves-effect waves-block waves-light\">
                            <img src='$image' width='373' height='373' >
                        </div>
                        <div class=\"card-content\">
                          <span class=\"card-title activator grey-text text-darken-1\" style=\"font-size:21px\">
                            Listed Price: $listingPrice <br>
                            Total Monthly Cost: $aggregateMonthlyCost <br>
                            Commute Time: $time <br><i class=\"material-icons right\">more_vert</i>
                          </span>
                        </div>
                        <div class=\"card-reveal\">
                          <span class=\"card-title grey-text text-darken-4\">Details<i class=\"material-icons right\">close</i></span>
                          <p>
                            Location: $address&nbsp$city,&nbsp$state&nbsp$zipcode <br>
                            Monthly Mortgage Bill: $monthlyMortgageCost <br>
                            Monthly Tax:           $monthly_tax_cost <br>
                            Monthly Electric Bill: $monthlyElectricityCost <br>
                            Monthly Gas Bill:      $monthlyNaturalGasCost <br>
                            Monthly Commute:       $monthlyCommute <br>
                            Number Bedrooms:  $bedrooms <br>
                            Number Bathrooms: $bathrooms <br>
                            Size:             $squareFeet sq. ft. <br>
                            Lot Size:         $lotSize <br>
                            Year Built:       $yearBuilt <br>
                            Commute Distance: $distance mi <br>
                          </p>
                        </div>
                    </div>
                </div>
            </div>
            </body>
            </html>";
        }

    }

    function sortByListingPrice($a,$b){
      if($a->ListPrice == $b->ListPrice)
        return 0;
      if($a->ListPrice > $b->ListPrice)
        return 1;
      else
        return -1;
    }
    function reverseSortByListingPrice($a,$b){
      if($a->ListPrice == $b->ListPrice)
        return 0;
      if($a->ListPrice > $b->ListPrice)
        return -1;
      else
        return 1;
    }

    function reverseSortByTotalMonthlyCost($a,$b){ //to fix in the future
      if(($a->TaxAnnualAmount / 12)==($b->TaxAnnualAmount / 12))
        return 0;
      if(($a->TaxAnnualAmount / 12)>($b->TaxAnnualAmount / 12))
        return -1;
      else
        return 1;
    }

    function sortByTotalMonthlyCost($a,$b){ //to fix in the future
      if(($a->TaxAnnualAmount / 12)==($b->TaxAnnualAmount / 12))
        return 0;
      if(($a->TaxAnnualAmount / 12)>($b->TaxAnnualAmount / 12))
        return 1;
      else
        return -1;
    }

    function sortBySquareFeet($a,$b){
      if($a->LivingArea == $b->LivingArea)
        return 0;
      if($a->LivingArea > $b->LivingArea)
        return 1;
      else
        return -1;
    }

    function reverseSortBySquareFeet($a,$b){
      if($a->LivingArea == $b->LivingArea)
        return 0;
      if($a->LivingArea > $b->LivingArea)
        return -1;
      else
        return 1;
    }

    function sortByCommuteDistance($a,$b)
    {
      $address = $a->StreetNumber . " " . $a->StreetDirPrefix . " " . $a->StreetName . " " . $a->StreetSuffix;
      $city = $a->City;
      $state = $a->StateOrProvince;
      $zipcode = $a->PostalCode;
      $commuteDistanceTime_a = googleDistanceMatrix($address, $city, $state, $zipcode);
      $distance_a = $commuteDistanceTime_a['distance'];


      $address = $b->StreetNumber . " " . $b->StreetDirPrefix . " " . $b->StreetName . " " . $b->StreetSuffix;
      $city = $b->City;
      $state = $b->StateOrProvince;
      $zipcode = $b->PostalCode;
      $commuteDistanceTime_b = googleDistanceMatrix($address, $city, $state, $zipcode);
      $distance_b = $commuteDistanceTime_b['distance'];

      if($distance_a == $distance_b)
        return 0;
      if($distance_a > $distance_b)
        return 1;
      else
        return -1;

    }

    function reverseSortByCommuteDistance($a,$b)
    {
      $address = $a->StreetNumber . " " . $a->StreetDirPrefix . " " . $a->StreetName . " " . $a->StreetSuffix;
      $city = $a->City;
      $state = $a->StateOrProvince;
      $zipcode = $a->PostalCode;
      $commuteDistanceTime_a = googleDistanceMatrix($address, $city, $state, $zipcode);
      $distance_a = $commuteDistanceTime_a['distance'];


      $address = $b->StreetNumber . " " . $b->StreetDirPrefix . " " . $b->StreetName . " " . $b->StreetSuffix;
      $city = $b->City;
      $state = $b->StateOrProvince;
      $zipcode = $b->PostalCode;
      $commuteDistanceTime_b = googleDistanceMatrix($address, $city, $state, $zipcode);
      $distance_b = $commuteDistanceTime_b['distance'];

      if($distance_a == $distance_b)
        return 0;
      if($distance_a > $distance_b)
        return -1;
      else
        return 1;

    }

    function sortListings($option){
      global $residentialListings;
      usort($residentialListings,$option);
    }

 ?>
