<?php
    require_once("../vendor/autoload.php");

    $eia_api_key = '7e98579fe8df595c44af2d056523f420';    //utility cost including electricity, gas
    //Propane cost
    //https://www.eia.gov/opendata/qb.php?category=241369

    $attom_api_key = 'a38f76c6891995290466517ef9c81623';

    function reso_call() {

        //API DOCUMENTATION  ->  https://rets.ly/docs/explorer/Property
        $reso_client_id = '3z8w7WfWtednQy3QhhWh';
        $dataset = 'abor_ref';    //currently using Austin dataset
        $access_token = '626af6da8489a7d2710d55f37619851c';
        $fields = 'StreetNumber,StreetDirPrefix,StreetName,StreetSuffix,City,StateOrProvince,PostalCode,ListPrice,TaxAnnualAmount,InsuranceExpense,PropertyType,Utilities,LivingArea,LotSizeAcres,BedroomsTotal,BathroomsTotalDecimal,YearBuilt';
        $limit = 10;
        //$select = 'Business';
        $sortBy = 'ListPrice';

        $near = $_POST['state'];
        if(!empty($_POST['zipcode'])) {
            $near = $_POST['zipcode'];
        }

        $radius = 500;   //get range from advanced search

        //listing details such as price, square feet, lot size, bedrooms, bathrooms, year built, etc.
        $listing_details_url = "https://api.bridgedataoutput.com/api/v2/$dataset/listings?access_token=$access_token&fields=$fields&limit=$limit&near=$near&radius=$radius&sortBy=$sortBy";

        //get JSON contents
        $result = @file_get_contents($listing_details_url);

        // Convert JSON string to Object
        $listings = json_decode($result);

        if (!empty($result)) {
        // Filter for capturing only residential listings within budget
        $budget = $_POST['budget'];
        $residentialListings = array();
        foreach($listings->bundle as $key => $value) {
            if ($listings->bundle[$key]->PropertyType == 'Residential') {
                if ($listings->bundle[$key]->ListPrice <= $budget) {
                  $residential = $listings->bundle[$key];
                  array_push($residentialListings, $residential);
                }
                $residential = $listings->bundle[$key];
                array_push($residentialListings, $residential);
            }
        }
            /*
            foreach($residentialListings as $key => $value) {
                $convertToString = json_encode($residentialListings[$key]);
                echo "<tr>$convertToString</tr>";
            }
            */
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
        $residentialListings = reso_call();

        foreach($residentialListings as $bundle) {
            $listingPrice = $bundle->ListPrice;
            $monthly_tax_cost = $bundle->TaxAnnualAmount / 12;

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

            $image = getImage($address, $city, $state, $zipcode);

            echo "<br><tr>
                      <img src='$image' height=200px width=200px>
                      Listed Price: $listingPrice <br>
                      Monthly Tax: $monthly_tax_cost <br>
                      Location: $address&nbsp$city,&nbsp$state&nbsp$zipcode <br>
                      Number Bedrooms: $bedrooms <br>
                      Number Bathrooms: $bathrooms <br>
                      Square Feet: $squareFeet <br>
                      Lot Size: $lotSize <br>
                      Year Built: $yearBuilt <br>
                  </tr>";
        }

    }

    function getImage($address, $city, $state, $zipcode) {
        $key = 'AIzaSyAdiSl1Nxhu1AhJM5jdrcgswUrAZrXUNOI';
        $location = $address . " " . $city . " " . $state . " " . $zipcode;
        $size = '1080x720';
        $image = "https://maps.googleapis.com/maps/api/streetview?key=$key&location=$location&size=$size";

        if(isset($image)) {
            return $image;
        }
        else {
            return "";
        }
    }
 ?>
