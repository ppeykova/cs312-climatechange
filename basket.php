<?php
    require('connect.php');
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
</head>
<body>
    <div>
        <?php include('header1.php'); ?>
    </div>
    <h1  style="margin-top: 100px">Your Basket</h1>
    <div id="table_container">
        <?php
            $totalPrice = 0;
            $offerId = [-1];

            $inValues = implode(',', $offerId);
            $stmt = $conn->prepare("SELECT * FROM `products` WHERE `id` IN (".$inValues.")");
            $stmt->execute();

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
                    $totalPrice += $row['offprice'];
                    echo "<tr>";
                    echo "<td><img src='data:image/jpeg;base64,".base64_encode($row['picture'])."'style='height:100px;'/></td>";
                    echo "<td>(".$row["category"].") ".$row['description']."</td>";
                    echo "<td>£".number_format($row["offprice"], 2)."</td>";
                    echo "<td>".$row["address"]."</td>";
                    echo "<td><button type='button', id='map_".$row['id']."'>View on Map</td>";
                    echo "</tr>";
                }
            }
        ?>
    </div>
    <div id="continue_order" style="float: right; margin: 20px 250px 0 0;">
        <?php
        if($stmt->rowCount() != 0)
        {
            echo "<p>Total price: £".number_format($totalPrice, 2)."</p>";
            echo "<p><button onclick=\"window.location.href = 'shop.php';\">Return to Shop</button>
                    <button>Confirm Order</button></p>";
        }
        ?>
    </div>
</body>
</html>
