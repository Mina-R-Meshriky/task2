<?php

function dd(...$vars) {
    var_dump($vars);
    die;
}

function ddj(...$var) {
    header("Content-type:application/json");
    echo json_encode(count($var) == 1 ? $var[0] : $var);
    die;
}