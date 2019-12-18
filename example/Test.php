<?php 
use OBJUI\Order;
require '../vendor/autoload.php';

try{
    $obj = new Order();
    echo '<pre>';
    print_r($obj->buy());
} catch (\Throwable $e) {
    echo '<pre>';
    print_r ($e);
} catch (\Error $e) {
    echo '<pre>';
    print_r ($e);
}



