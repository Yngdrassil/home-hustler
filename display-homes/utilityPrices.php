<html>
<?php

    $eia_api_key = '7e98579fe8df595c44af2d056523f420';    //Energy Information Administration API key

    function electricityPrice($stateCode) {
      $url = "https://api.eia.gov/series/?api_key=7e98579fe8df595c44af2d056523f420&series_id=ELEC.PRICE.$stateCode-RES.A";
      $result = file_get_contents($url);
      $data = json_decode($result);
      $electricityPriceArray = $data->series[0]->data;

      $electricityPrice = 0;
      foreach($electricityPriceArray as $price) {
          if(isset($price[1])) {
              $electricityPrice = $price[1];            //get most recent year's average cost for provided state in CENTS/KWH
              break;
          }
      }

      $electricityPrice /= 100;                           //convert to DOLLARS/KWH
      //echo "<div> $electricityPrice </div>";
      return $electricityPrice;
    }

    function electricityConsumption($squareFeet) {

        $b1 = 14;                                    //Square Feet Coefficient, kwh consumed per Square Foot PER YEAR

        $kwhEstimate = ($b1 * $squareFeet) / 12;    //PER MONTH
        //echo "<div> $kwhEstimate </div>";
        return $kwhEstimate;
    }

    function monthlyElectricityCost($stateCode, $squareFeet) {
        $kwhRate = electricityPrice($stateCode);
        $kwhConsumption = electricityConsumption($squareFeet);

        $estimatedCost = round($kwhRate * $kwhConsumption, 2);

        return $estimatedCost;
    }

    function hasElectricity($utilities) {

        foreach($utilities as $utility) {
            if( strpos($utility, 'Electricity Not') !== false) {    //test if electricity is NOT available
                return false;
            }
        }
        return true;                                               //otherwise assume electricity is available
    }

    function naturalGasPrice($stateCode) {
      $url = "http://api.eia.gov/series/?api_key=7e98579fe8df595c44af2d056523f420&series_id=NG.N3010" . $stateCode . "3.A";

          //  http://api.eia.gov/series/?api_key=YOUR_API_KEY_HERE&series_id=NG.N3010AL3.A

      $result = file_get_contents($url);
      $data = json_decode($result);
      $gasPriceArray = $data->series[0]->data;

      $gasPrice = 0;
      foreach($gasPriceArray as $price) {
          if(isset($price[1])) {
              $gasPrice = $price[1];            //per thousand cubic feet
              break;
          }
      }
      $gasPrice /= 1000;                   //per cubic foot

      return $gasPrice;
    }

    function naturalGasConsumption($squareFeet) {

        $b1 = 31;                           //Cubic feet consumed per Square Foot, annualized

        $cubicFeet = ($b1 * $squareFeet) / 12.0;   //Monthly
        return $cubicFeet;
    }

    function monthlyNaturalGasCost($stateCode, $squareFeet) {
      $cubicFeetRate = naturalGasPrice($stateCode);
      $cubicFeetConsumption = naturalGasConsumption($squareFeet);

      $estimatedCost = round($cubicFeetRate * $cubicFeetConsumption, 2);    //price per cubic foot * estimate of cubic feet used

      //echo "<div>$estimatedCost</div>";
      return $estimatedCost;
    }

    function propanePrice($stateCode) {
      //Propane cost
      //https://www.eia.gov/opendata/qb.php?category=241369
    }
?>
</html>
