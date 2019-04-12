<?php

    function toMoney($val,$symbol='$',$r=2)
    {
        error_reporting(0);
        $n = $val;

        if(is_float($val)) {
            number_format($n, $r);
        }

        $d = '.';
        $t = ',';
        $sign = ($n < 0) ? '-' : '';
        $i = $n=number_format(abs($n),$r);            //whole number portion
        $j = (($j = strlen($i)) > 3) ? $j % 3 : 0;    //comma iterator

        return  $symbol.$sign .($j ? substr($i,0, $j) + $t : '').preg_replace('/(\d{3})(?=\d)/',"$1" + $t,substr($i,$j));
    }

?>
