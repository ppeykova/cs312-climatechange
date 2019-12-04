<?php
require ('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body class="profile-page sidebar-collapse">
<div class="page-header header-filter" data-parallax="true" style="background-image: url('material-kit-master/assets/img/banana.jpg')">
    <div class="container">
        <?php
        require('header1.php'); ?>
        <div class="brand text-center">
            <h1>My account</h1>
        </div>
    </div>
</div>
<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <div class="col-md-10 ml-auto mr-auto">
                <h2>Your offers still on sale</h2>
                <?php
                function selectWhereEmail($email){
                    return 'SELECT * FROM `products` WHERE email = "'.$email.'"';
                }
                function selectWhereEmailSold($email){
                    return 'SELECT * FROM `soldProducts` WHERE email = "'.$email.'" AND timestamp  >= CURDATE() - 7';
                }
                function listProducts($array)
                {
                    echo "<tr>";
                    echo "<div class='d-sm-table-row'>";
                    echo "<div class='card-columns'>";
                    for($j=0; $j < count($array); $j = $j + 3) {
                        $image = $array[$j]['picture'];
                        $description = $array[$j]['description'];
                        $price = $array[$j]['offprice'];
                        echo "<div class='card-group card'>
               <img class='card-img-top' style='max-height: 300px' src='data:image/jpeg;base64," . base64_encode($image) . "'/>" . "<div class='card-body'><p class='card-text'> $description </p><p class='card-text'> £".number_format($price, 2)."</p></div></div>";
                    }
                    echo "</div></div>";
                    echo "</tr>";
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
                    echo "<div class='col text-center'>";
                    echo "<p>No products on sale.</p></div>";
                }
                ?>
                <h2>Your sold offers</h2>
                <div class='row'>
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
                        echo "<div class='col text-center'>";
                        echo "<p>No products sold in the last week.</p></div>";
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php require('footer.php');
?>
</body>
</html>
