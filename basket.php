<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Basket</title>
    <script>
        function removeFromBasket(id)
        {
            var basketCookie = [];
            if(Cookies.get('basket') != undefined)
                basketCookie = JSON.parse(Cookies.get('basket'));
            basketCookie.splice(basketCookie.indexOf(id), 1);
            Cookies.set('basket', JSON.stringify(basketCookie));
            alert("Product removed from basket");
            window.location.href = "basket.php";
        }
    </script>
</head>
<body class="profile-page sidebar-collapse">
<div class="page-header header-filter" data-parallax="true">
    <div class="container">
        <?php
        require('header1.php');
        ?>
        <div class="brand text-center">
            <h1>Your Basket</h1>
        </div>
    </div>
</div>
<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <div class="row">

                <?php
                $var = "basket";

                function sendOrderEmail()
                {
                    if(isset($_COOKIE['basket']))
                    {
                        $offerId = json_decode($_COOKIE['basket']);
                        $inValues = implode(',', $offerId);
                        $stmt = queryDB("SELECT * FROM `products` WHERE `id` IN (".$inValues.")");
                        $email = $_SESSION['email'];
                        $subject = "Wastood Order Invoice";
                        $headers = 'From: orders@wastood.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
                        $message = "Thank you for your order.\n\nOrder Details:\n";
                        $totalPrice = 0;
                        $totalGenPrice = 0;
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                        {
                            $totalPrice += $row['offprice'];
                            $totalGenPrice += $row['genprice'];
                            $message .= "(".$row["category"].") ".$row['description']." - £".number_format($row['offprice'], 2)." - ".$row['address']."\n\n";
                        }
                        $message .= "Order total: £".number_format($totalPrice, 2);
                        if (mail($email, $subject, $message, $headers))
                            return $totalGenPrice - $totalPrice;
                        else
                            return -1;
                    }
                    else
                        return -1;
                }
                function queryDB($query)
                {
                    require('connect.php');
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    return $stmt;
                }
                ?>

                <div class="col-md-8 ml-auto mr-auto">
                    <?php
                    $sold = false;
                    if(isset($_POST['submit']))
                    {
                        if(!isset($_SESSION['email']))
                        {
                            echo "<div class='text-center'>";
                            echo "<p id='loginMessage'>Error: User is not logged in</p><br/>
                  <p>Please <a href='login.php?var=".$var."'>Login</a> first.</p>";
                            die();
                            echo "</div>";
                        }
                        else{
                            if (($savedCost = sendOrderEmail()) != -1) {
                                echo "<p id='orderMessage'>Order successful! You have saved £".number_format($savedCost, 2)."! An email confirmation has been sent to you.</p>";
                                $sold = true;
                            } else {
                                echo "<p id='orderMessage'>Your order could not be made, please try again...</p>";
                            }
                        }

                    }
                    $totalPrice = 0;
                    $totalGenPrice = 0;
                    if(isset($_COOKIE['basket']))
                    {
                        $offerId = json_decode($_COOKIE['basket']);
                        if(empty($offerId))
                            $offerId = [-1];
                    }
                    else
                        $offerId = [-1];
                    $inValues = implode(',', $offerId);
                    $stmt = queryDB("SELECT * FROM `products` WHERE `id` IN (".$inValues.")");
                    if($sold)
                    {
                        if($stmt->rowCount() != 0)
                        {
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                            {
                                require('connect.php');
                                $stmt2 = $conn->prepare("INSERT INTO `soldProducts` (`picture`, `category`, `description`, `genprice`, `offprice`, `address`, `email`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                                if($stmt2->execute([$row['picture'], $row['category'], $row['description'], $row['genprice'], $row['offprice'], $row['address'], $_SESSION['email']]) === true)
                                {
                                    $id = $row['id'];
                                    $stmt2 = $conn->prepare("DELETE FROM `products` WHERE `products`.`id` = $id");
                                    $stmt2->execute();
                                }
                            }
                        }
                    }
                    else
                    {
                        if($stmt->rowCount() == 0)
                        {
                            echo "<p>There are no items in your basket.</p>";
                           // echo "<button class='btn btn-primary' onclick='window.location.href = 'shop.php';'>Return to Shop</
                            ?> <a href='shop.php'> Return to shop</a> <?php
                        }
                        else
                        {
                            echo "<div class='table-responsive'>";
                            echo "<table class='table'>";
                            echo "<tr>
                                   <div class='col'>
                                    <th class='th-description'>Image</th><th class='th-description'>Description</th><th class='th-description'><del>Original Price</del></th><th class='th-description'>Offer Price</th><th class='th-description'>Address</th><th class='label'>Map</th><th class='label'></th></div></tr>";
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                            {
                                $id = $row['id'];
                                $totalPrice += $row['offprice'];
                                $totalGenPrice += $row['genprice'];
                                echo "<tr>
                                        <div class='col'>";
                                echo "<div class='card' style='width: 20rem;'>";
                                echo "<td><img class='card-img-top' style='max-height: 300px;' src='data:image/jpeg;base64,".base64_encode($row['picture'])."'style='height:100px;'/></td>";
                                echo "<div class='card-body'>";
                                echo "<td class='card-text'>(".$row["category"].") ".$row['description']."</td>";
                                echo "<td class='card-text'><del>£".number_format($row["genprice"], 2)."</del></td>";
                                echo "<td class='card-text'>£".number_format($row["offprice"], 2)."</td>";
                                echo "<td class='card-text'>".$row["address"]."</td>";
                                $address = str_replace(' ', '+', $row['address']);
                                $url ="https://maps.google.com.au/maps?q=". $address;
                                echo "<td class='card-text'><a href=$url onclick='return !window . open(this . href, 'Google', 'width=800,height=800')' target='_blank'>View location map</a></td>";
                                echo "<td><button class='btn btn-primary' type='button' id='remove_".$id."' onclick='removeFromBasket($id)'>Remove From Basket</td> 
                                </div></div>";
                                echo "</div></tr>";
                            }
                            echo "</table></div>";
                        }
                    }
                    ?>
                </div>
            </div>
            <div id="confirm_order_box" class="modal-footer">
                <?php
                if(!$sold) {
                    if ($stmt->rowCount() != 0) {
                        echo "<form method='POST' action='basket.php'>";
                        echo "<h4>Total price: £" . number_format($totalPrice, 2) . "</h4>";
                      ?>  <a href='shop.php'> Return to shop</a> <?php
                        //echo "<button class='btn btn-primary' type='button' href='shop.php'>Return to Shop</button>
                        echo "<button class='btn btn-primary' name='submit' type='submit'>Confirm Order</button>
                        </form>";
                    }
                }else{
                ?><a href='shop.php'> Return to shop</a> <?php
                    //echo "<button class='btn btn-primary' type='button' onclick=\"window.location.href = 'shop.php';\">Return to Shop</button></form>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.php');
?>
</body>
</html>