<?php
session_start();
if($_POST['action'] == 'buy') {
    $db = new mysqli("localhost", "root", "", "Products");
    $db->begin_transaction();
    $items = array();
    $result = $db->query("SELECT name, number FROM items");
    foreach ($result as $item) {
        $items[$item['name']] = $item['number'];
    }
    foreach ($_SESSION as $key => $value) {
//        echo ($key);
        if ($value[1] <= $items[$key]) {
            if ($value[1] == $items[$key]) {
                $stmt = $db->prepare("DELETE from items where name = ?");
                $stmt->bind_param("s", $key);
                $result = $stmt->execute();
            }
            else {
                $stmt = $db->prepare("update items set number = ? where name = ?");
                $new_number = $items[$key] - $value[1];
                $stmt->bind_param("is", $new_number, $key);
                $result = $stmt->execute();
            }
//            echo "Można kupić ";
//            echo $key;
//            echo " ";
//            echo $value[1];
//            echo " ";
//            echo $items[$key];
//            printf("<br>");
        }
        else {
            $db->rollback();
            foreach( $_SESSION as $name_of_item => $number_of_items) {
                unset($_SESSION[$name_of_item]);
            }
            header("Location:". strtok($_SERVER["HTTP_REFERER"],'?')."?error=2"); // couldn't buy one or more items
            exit();
        }
        }
    $db->commit();
    foreach( $_SESSION as $key => $value) {
        unset($_SESSION[$key]);
    }
    header("Location:". strtok($_SERVER["HTTP_REFERER"],'?')."?success=2"); // Bought all items
}
else if ($_POST['action'] == 'clear') {
    foreach( $_SESSION as $key => $value) {
        unset($_SESSION[$key]);
    }
    header("Location:". strtok($_SERVER["HTTP_REFERER"],'?'));
}
