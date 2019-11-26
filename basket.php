<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Basket</title>
    <link rel="stylesheet" type="text/html" href="uikit-3.2.3/css/uikit.min.css" />
    <script src="uikit-3.2.3/js/uikit.min.js"></script>
    <script src="uikit-3.2.3/js/uikit-icons.min.js"></script>
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
<body>
<div>
    <?php include('header1.php'); ?>
</div>
<?php
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
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $totalPrice += $row['offprice'];
            $message .= "(".$row["category"].") ".$row['description']." - £".number_format($row['offprice'], 2)." - ".$row['address']."\n\n";
        }
        $message .= "Order total: £".number_format($totalPrice, 2);
        if (mail($email, $subject, $message, $headers))
            return true;
        else
            return false;
    }
    else
        return false;
}
function queryDB($query)
{
    require('connect.php');
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt;
}
?>
<h1  style="margin-top: 100px">Your Basket</h1>
<div id="table_container">
    <?php
    $sold = false;
    if(isset($_POST['submit']))
    {
        if(sendOrderEmail())
        {
            echo "<p id='orderMessage'>Order successful! An email confirmation has been sent to you.</p>";
            $sold = true;
        }
        else
        {
            echo "<p id='orderMessage'>Your order could not be made, please try again...</p>";
        }
    }
    $totalPrice = 0;
    if(isset($_COOKIE['basket']))
        $offerId = json_decode($_COOKIE['basket']);
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
            echo "<p><button onclick=\"window.location.href = 'shop.php';\">Return to Shop</button></p>";
        }
        else
        {
            echo "<table id='basket_table'>";
            echo "<tr><th>Image</th><th>Description</th><th>Offer Price</th><th>Address</th><th></th></tr>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $id = $row['id'];
                $totalPrice += $row['offprice'];
                echo "<tr>";
                echo "<td><img src='data:image/jpeg;base64,".base64_encode($row['picture'])."'style='height:100px;'/></td>";
                echo "<td>(".$row["category"].") ".$row['description']."</td>";
                echo "<td>£".number_format($row["offprice"], 2)."</td>";
                echo "<td>".$row["address"]."</td>";
                $address = str_replace(' ', '+', $row['address']);
                $url ="https://maps.google.com.au/maps?q=". $address;
                echo "<td><a href=$url onclick=\"return !window . open(this . href, 'Google', 'width=800,height=800')\" target=\"_blank\"> View location map </a></td>";
                echo "<td><button type='button', id='remove_".$id."' onclick='removeFromBasket($id)'>Remove From Basket</td>";
                echo "</tr>";
            }
        }
    }
    ?>
</div>
<div id="confirm_order_box" style="float: right; margin: 20px 250px 0 0;">
    <?php
    if($stmt->rowCount() != 0)
    {
        echo "<form method='POST' action='basket.php'>";
        echo  "<p>Total price: £".number_format($totalPrice, 2)."</p>";
        echo "<p><button onclick=\"window.location.href = 'shop.php';\">Return to Shop</button>
                        <button name='submit' type='submit'>Confirm Order</button></p></form>";
    }
    ?>
</div>
</body>
</html>