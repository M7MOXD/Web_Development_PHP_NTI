<?php
    function Alpha($letter) {
        $alphabetCap = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $alphabetLower = "abcdefghijklmnopqrstuvwxyz";
        if (strpos($alphabetCap, $letter) || strpos($alphabetCap, $letter) === 0) {
            $index = (strpos($alphabetCap, $letter) + 1) === 26 ? 0 : strpos($alphabetCap, $letter) + 1;
            echo $alphabetCap[$index];
        }
        if (strpos($alphabetLower, $letter) || strpos($alphabetLower, $letter) === 0) {
            $index = (strpos($alphabetLower, $letter) + 1) === 26 ? 0 : strpos($alphabetLower, $letter) + 1;
            echo $alphabetLower[$index];
        }
    };
    Alpha("A");
    echo "<br>";
    Alpha("a");
    echo "<br>";
    Alpha("B");
    echo "<br>";
    Alpha("b");
    echo "<br>";
    Alpha("Z");
    echo "<br>";
    Alpha("z");
?>