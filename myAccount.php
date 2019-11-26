<?php
require ('connect.php');
require ('header1.php');

?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
    </head>
<body>
<h1>
    Your offers still on sale
</h1>
<?php

function selectWhereEmail($email){
    return 'SELECT * FROM `products` WHERE email = "'.$email.'"';
}
function selectWhereEmailSold($email){
    return 'SELECT * FROM `soldProducts` WHERE email = "'.$email.'"';
}
function listProducts($array)
{
    for($j=0; $j < count($array); $j = $j + 3) {

            $image = $array[$j]['picture'];
            $description = $array[$j]['description'];
            $price = $array[$j]['offprice'];

                echo "<div class='card' style='width: 20rem;'>
                              <td><img class='card-img-top' style='max-height: 300px' src='data:image/jpeg;base64," . base64_encode($image) . "'/>" . "<div class='card-body'><p class='card-text'> $description </p><p class='card-text'> £ $price </p></div></div></td>";


    }
}
$email = $_SESSION['email'];
$sql = selectWhereEmail($email);

$result = $conn->query($sql);
if (!$result) {
    die("Query failed.");
}

$arrayOnsale = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $arrayOnsale[] = $row;
}
if ($result->rowCount() > 0) {
    listProducts($arrayOnsale);
} else {
    echo "No products on sale.";
}

?>


<h1>
    Your sold offers
</h1>
<?php
$sql = selectWhereEmailSold($email);

$result = $conn->query($sql);
if (!$result) {
    die("Query failed.");
}

$arraySold = array();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $arraySold[] = $row;
}
if ($result->rowCount() > 0) {
    listProducts($arraySold);
} else {
    echo "No products sold in the last week.";
}
?>
</body>
</html>