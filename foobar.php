<?php

// loop through numbers 1 through 100 inclusive
for ($x = 1; $x <= 100; $x++ ) {
    // first we must check case that $x is divisble by both 3 and 5
    if ($x % 3 == 0 && $x % 5 == 0) {
        echo "foobar";
    } elseif ($x % 3 == 0){ // can check individual cases after
        echo "foo";
    } elseif ($x % 5 == 0) {
        echo "bar";
    } else {        // default, print the current number if not divisible by 3 or 5
        echo $x;
    }
    echo ", ";  // print comma and space for ease of viewing

}