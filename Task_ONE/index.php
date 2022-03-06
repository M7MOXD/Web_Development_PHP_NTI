<?php
    $units = 60;
    $cost = 0;
    if ($units > 150) {
        $f50 = 50;
        $x100 = 100;
        $remain = $units - ($f50 + $x100);
        $cost = ($f50 * 3.5) + ($x100 * 4) + ($remain * 6.5);
    } else {
        $f50 = 50;
        $remain = $units - $f50;
        if ($remain > 0) {
            $cost = ($f50 * 3.5) + ($remain * 4);
        } else {
            $cost = ($f50 * 3.5);
        }
    }
    echo $cost;
?>