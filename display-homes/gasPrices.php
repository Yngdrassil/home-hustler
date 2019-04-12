<?php
    require('html-parser/simple_html_dom.php');

    function getGasPrice($stateCode) {

        $states = array(
            'Alabama'=>'AL',
            'Alaska'=>'AK',
            'Arizona'=>'AZ',
            'Arkansas'=>'AR',
            'California'=>'CA',
            'Colorado'=>'CO',
            'Connecticut'=>'CT',
            'Delaware'=>'DE',
            'District of Columbia'=>'DC',
            'Florida'=>'FL',
            'Georgia'=>'GA',
            'Hawaii'=>'HI',
            'Idaho'=>'ID',
            'Illinois'=>'IL',
            'Indiana'=>'IN',
            'Iowa'=>'IA',
            'Kansas'=>'KS',
            'Kentucky'=>'KY',
            'Louisiana'=>'LA',
            'Maine'=>'ME',
            'Maryland'=>'MD',
            'Massachusetts'=>'MA',
            'Michigan'=>'MI',
            'Minnesota'=>'MN',
            'Mississippi'=>'MS',
            'Missouri'=>'MO',
            'Montana'=>'MT',
            'Nebraska'=>'NE',
            'Nevada'=>'NV',
            'New Hampshire'=>'NH',
            'New Jersey'=>'NJ',
            'New Mexico'=>'NM',
            'New York'=>'NY',
            'North Carolina'=>'NC',
            'North Dakota'=>'ND',
            'Ohio'=>'OH',
            'Oklahoma'=>'OK',
            'Oregon'=>'OR',
            'Pennsylvania'=>'PA',
            'Rhode Island'=>'RI',
            'South Carolina'=>'SC',
            'South Dakota'=>'SD',
            'Tennessee'=>'TN',
            'Texas'=>'TX',
            'Utah'=>'UT',
            'Vermont'=>'VT',
            'Virginia'=>'VA',
            'Washington'=>'WA',
            'West Virginia'=>'WV',
            'Wisconsin'=>'WI',
            'Wyoming'=>'WY'
        );

        $html = file_get_html('https://gasprices.aaa.com/state-gas-price-averages/');

        $priceArray = array();
        foreach($html->find('tr') as $row) {
            error_reporting(0);   //turn off erroneous error reports
            $state = $row->find('a', 0)->plaintext;
            $priceRow['stateCode'] = $states[$state];     //get state code for compatability with search
            $priceRow['regular'] = substr($row->find('td.regular', 0)->plaintext, 1);     //use substr to remove dollar sign
            $priceRow['mid_grade'] = substr($row->find('td.mid_grade', 0)->plaintext, 1);
            $priceRow['premium'] = substr($row->find('td.premium', 0)->plaintext, 1);     //use find function from DOM html parser
            $priceRow['diesel'] = substr($row->find('td.diesel', 0)->plaintext, 1);       //to scrape data from html elements

            array_push($priceArray, $priceRow);
        }

        foreach($priceArray as $priceRow) {
            $regular = $priceRow['regular'];
            if($priceRow['stateCode'] == $stateCode) {
                return $regular;
            }
        }

        /* --UNIT TEST--
        error_reporting(1);     //turn back on in case of boo-boo
        foreach($priceArray as $priceRow) {
            $state_code = $priceRow['stateCode'];
            $regular = $priceRow['regular'];
            $mid_grade = $priceRow['mid_grade'];
            $premium = $priceRow['premium'];
            $diesel = $priceRow['diesel'];
            echo "<div>
                      $state_code
                      $regular
                      $mid_grade
                      $premium
                      $diesel
                  </div>";
        }
        */
    }
?>
