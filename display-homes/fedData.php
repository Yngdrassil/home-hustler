<?php
    $fred_key = '329ab4b9ba860d47985613b66fcfe45c';

    function get30YrFixedMortgageRate() {
        $url = "https://api.stlouisfed.org/fred/series/observations?series_id=MORTGAGE30US&frequency=m&output_type=1&observation_start=2018-01-01&api_key=329ab4b9ba860d47985613b66fcfe45c&file_type=json";
        $request = file_get_contents($url);

        $data = json_decode($request);

        $mortgageRates = $data->observations;

        end($mortgageRates);
        prev($mortgageRates);

        $mortgageRate = current($mortgageRates)->value / 100;     //turn into decimal

        return $mortgageRate;

    }
?>
