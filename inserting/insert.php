<?php

function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
    $numbers = range($min, $max);
    shuffle($numbers);
    return array_slice($numbers, 1, $quantity);
}
print_r( UniqueRandomNumbersWithinRange(0,1000,1000) );

 ?>
