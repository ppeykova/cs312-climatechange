<?php
require ('connect.php');
$categoryType = "";
$mainArea = "";
if(isset($_POST['submit'])){
    if(isset($_POST['category'])) {
        $categoryType = $_POST['category'];
    }
    if(isset($_POST['area'])) {
        $mainArea = $_POST['area'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="uikit-3.2.3\css\uikit.min.css" />
    <script src="uikit-3.2.3\js\uikit.min.js"></script>
    <script src="uikit-3.2.3\js\uikit-icons.min.js"></script>
    <title>My Account</title>
    <style>
        img {
            border: 1px solid black;
            background-color: black;
            border-radius: 1px;
            padding: 2px;
            height: 200px;
        }

    </style>
    <title>Home</title>

</head>
<body>
<div>
    <?php
    include('header.php');

    $userName = $_SESSION['name'];
    echo "<p>Name: <b>".$userName."</b></p>";
    
    ?>
</div>

<h1>Items in the Marketplace</h1>

<?php

function select(){
    $userEmail = $_SESSION['email'];
    return "SELECT * FROM `products` WHERE `email =` '.$userEmail.'";
}

function select2(){
    return "SELECT * FROM `products` WHERE `email` = 2";
}

function listProducts($array){
echo "</br>";
echo "<table>\n";
    for ($j=0; $j < count($array); $j = $j + 3) {
    echo "<tr>\n";
        for($c=0; $c < 3; $c++) {
        if(!empty($array[$j + $c])) {
        $id = $array[$j + $c]['id'];
        $image = $array[$j + $c]['picture'];
        $description = $array[$j + $c]['description'];
        $price = $array[$j + $c]['offprice'];
        echo "<br><td><img src='data:image/jpeg;base64," . base64_encode($image) . "'/>" . "</br> $description </br> £ $price </br> <button> Add to basket </button></td>\n";
        }
        }
        echo "</tr>\n";
    }
    echo "</table>\n";
}

$array = array();
$sql = select();
$result = $conn->query($sql);
if (!$result) {
    die("Query failed.");
}
unset($array);
$array = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $array[] = $row;
}
if ($result->rowCount() > 0) {
    listProducts($array);
} else {
    echo "No products available of this criteria. Try again later.";
}
?>

<h1>Items Sold</h1>

<?php

function select1(){
    $userEmail = $_SESSION['email'];
    return "SELECT * FROM `Products` WHERE `email =` '.$userEmail.'";
}

function listProducts1($array){
    echo "</br>";
    echo "<table>\n";
    for ($j=0; $j < count($array); $j = $j + 3) {
        echo "<tr>\n";
        for($c=0; $c < 3; $c++) {
            if(!empty($array[$j + $c])) {
                $id = $array[$j + $c]['id'];
                $image = $array[$j + $c]['picture'];
                $description = $array[$j + $c]['description'];
                $price = $array[$j + $c]['offprice'];
                echo "<br><td><img src='data:image/jpeg;base64," . base64_encode($image) . "'/>" . "</br> $description </br> £ $price </br> <button> Add to basket </button></td>\n";
            }
        }
        echo "</tr>\n";
    }
    echo "</table>\n";
}

$array = array();
$sql = select();
$result = $conn->query($sql);
if (!$result) {
    die("Query failed.");
}
unset($array);
$array = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $array[] = $row;
}
if ($result->rowCount() > 0) {
    listProducts($array);
} else {
    echo "No products available of this criteria. Try again later.";
}
?>

</body>
</html>
