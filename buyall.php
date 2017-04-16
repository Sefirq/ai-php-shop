<?php
session_start();
if($_POST['action'] == 'call_this') {
    $array = array();
    foreach ($_SESSION as $key => $value) {
        echo ($key);
    }
}
