<?php

for ($x = 1; $x <= 100; $x++ ) {
    if ($x % 3 == 0 && $x % 5 == 0) {
        echo "foobar";
    } elseif ($x % 3 == 0){
        echo "foo";
    } elseif ($x % 5 == 0) {
        echo "bar";
    } else {
        echo $x;
    }
    echo ", ";

}