<?php
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();
?>
<html>
<head>
    <title>Console shop</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="/scripts/script.js"></script>
    <link rel="stylesheet" href="/styles/style.css?ts=<?=time()?>&quot; />" type="text/css"/>
</head>
<body background="https://s-media-cache-ak0.pinimg.com/736x/9f/4c/05/9f4c05a2ff8f02a72bdb55c9417dbb6e.jpg">
<h1 id="tops">Best shop</h1>
    <?php
    if (isset($_GET['error'])) {
        if($_GET['error'] == 1) {
            echo '<script type="text/javascript">alert("Too many items chosen")</script>';
            unset($_GET['error']);
        }
        if($_GET['error'] == 2) {
            echo '<script type="text/javascript">alert("You couldn\'t buy the items")</script>';
            unset($_GET['error']);
        }
    }
    if (isset($_GET['success'])) {
        if($_GET['success'] == 2) {
            echo '<script type="text/javascript">alert("You bought all the items!")</script>';
            unset($_GET['success']);
        }
    }
    $link = mysqli_connect("localhost", "root", "", "Products");
    if(!$link){
        printf("Couldn't connect to database.\n");
        exit();
    }
    $result = mysqli_query($link, "SELECT * FROM items");
    printf("<h4>Products in the database:</h4>");
    $fields = mysqli_fetch_fields($result);
    printf("<table class='center'>");
    printf("<tr class='header'><th>%s</th><th>%s</th><th>%s</th><th>%s</th></tr>",$fields[0]->name,$fields[1]->name,$fields[2]->name,"Action");
    $i = 0;
    $items = array();
    while ($row = mysqli_fetch_array($result)) {
        $items[$i] = $row;
        $i++;
    }
    foreach ($items as $index=>$row) {
        $sth = "<a href='/add_to_basket.php?name=".$row[0]."&number=".$row[1]."' class='link_dialog' >Add to basket</a>";
        printf("<tr><td>%s</td><td>%s</td><td>%s</td> <td>%s</td></tr>",$row[0],$row[1],$row[2]."zł", $sth);
    }
    printf("</table>");
    mysqli_free_result($result);
    mysqli_close($link);
    ?>
<hr>
<h4>Your basket:</h4>
<?php
printf("<table class='center' id='baskettable'>");
printf("<tr class='header'><th>%s</th><th>%s</th><th>%s</th><th>%s</th></tr>",$fields[0]->name,$fields[1]->name,$fields[2]->name, "Action");
$in_basket = array();
foreach ($items as $index=>$row){
    if (isset($_SESSION[$row[0]])){
        $in_basket[$row[0]] = array($row[0], $_SESSION[$row[0]][1], $row[2]); // if the product is in session, he is in basket
        $link_to_script = "<a href='/delete_from_session.php?name=".$row[0]."'>Delete from basket</a>";
        printf("<tr><td>%s</td><td class='number'>%s</td><td class='price'>%s</td><td>%s</td></tr>",$row[0],$_SESSION[$row[0]][1],$row[2]."zł", $link_to_script);
    }
    else {
        if(isset($in_basket[$row[0]])) {
            unset($in_basket[$row[0]]);
        }
    }
}
printf("</table>");
?>
<div class="centered">
    <p>You will have to pay: <span id="totalprice"></span>zł. </p>
</div>
<form name="myLetters" action="/buyall.php" method="POST">
    <div class="centered">
        <?php
        printf("<button type='submit' name='action' value='clear'>Clear the basket</button>")
        ?>
    </div>
</form>
<form name="myLetters" action="/buyall.php" method="POST">
    <div class="centered">
<?php
printf("<button type='submit' name='action' value='buy'>Buy all items from basket</button>")
?>
    </div>
</form>

<div id="opened">
    <p>Type number of items to add</p>
    <form><input type="text" style="z-index:10000" name="name"><br></form>
</div>
</body>
</html>