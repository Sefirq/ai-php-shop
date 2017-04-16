<?php
session_start();
if (isset($_GET['name']) && isset($_GET['nr']) && isset($_GET['number'])){
    if ($_GET['number'] >= $_GET['nr']){
        add_to_basket($_GET['name'], $_GET['nr']);
        header("Location:". strtok($_SERVER["HTTP_REFERER"],'?'));
    }
    else {
        header("Location:". $_SERVER['HTTP_REFERER']."?error=1");
    }
}
function add_to_basket($name, $number){
    echo "setetete";
    if(isset($_SESSION[$name])){
        $_SESSION[$name] = array($name, $_SESSION[$name][1]+$number);
    }
    else {
        $_SESSION[$name] = array($name, $number);
    }
}
