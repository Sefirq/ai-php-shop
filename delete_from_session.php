<?php
session_start();
if (isset($_GET['name'])){
    delete_from_session($_GET['name']);
}
function delete_from_session($name){
    echo "delet this";
    unset($_SESSION[$name]);
}
header("Location:". strtok($_SERVER["HTTP_REFERER"],'?'));