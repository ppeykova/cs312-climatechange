<?php

require ('header.php');

if(!isset($_SESSION['user'])){
    echo '<script>alert("You must be logged in");location.href="login.php";</script>';
}
else {
$_SESSION['output_message'] = "";
$areas = ["City Centre", "East End", "West End", "South Side", "North Side"];
$categories = ["Beans", "Bakery", "Dairy", "Drinks", "Fruit", "Meat", "Nuts", "Ready Meals", "Sweets", "Vegetables"];
$maxPrices = [5, 10, 5, 10, 5, 10, 5, 15, 5, 5];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="uikit-3.2.3\css\uikit.min.css"/>
    <script src="uikit-3.2.3\js\uikit.min.js"></script>
    <script src="uikit-3.2.3\js\uikit-icons.min.js"></script>
    <script src="addOffer.js"></script>
    <script>
        var maxPrices = <?php echo json_encode($maxPrices); ?>;

        function submitForm() {
            document.offerForm.submit();
        }
    </script>
    <style>
        body {
            margin-left: 50px;
        }

        label span {
            display: inline-block;
            width: 120px;
            text-align: right;
            padding-right: 20px;
        }

        .error {
            color: red;
            width: auto;
        }
    </style>
    <title>Add Offer</title>
</head>
<body>
<?php
if (!$_SESSION['user']) {
    echo "<p>Error: User is not logged in</p>";
    die();
}
if (isset($_POST['category'])) {
    sendToDB();
}
function sendToDB()
{
    if (!empty($_FILES['image']['tmp_name']))
        $image = file_get_contents($_FILES['image']['tmp_name']);
    else
        $image = "";
    $category = $_POST['category'];
    $retailPrice = $_POST['retailPrice'];
    $offerPrice = $_POST['offerPrice'];
    $description = $_POST['description'];
    $area = $_POST['addrArea'];
    $address = $_POST['addrStreet'] . ', ' . $_POST['addrCity'] . ', ' . $_POST['addrPostcode'];
    if (checkAddress()) {
        // Connect and send to database
        require('connect.php');
        $stmt = $conn->prepare("INSERT INTO `products` (`picture`, `category`, `description`, `genprice`, `offprice`, `address`, `area`, `user_id`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$image, $category, $description, $retailPrice, $offerPrice, $address, $area, $_SESSION['user_id']]) === true)
            $_SESSION['output_message'] = "Offer added successfully!";
        else
            $_SESSION['output_message'] = "Error: Offer could not be added, please try again...";
    }
}

// Check if address entered is a valid address
function checkAddress()
{
    return true;
}

?>
<h1>Add an Offer</h1>
<form name="offerForm" method="POST" action="" enctype="multipart/form-data">
    <p><?php if (isset($_POST['category'])) {
            echo $_SESSION['output_message'];
        } ?></p>
    <p>Required fields marked with <span style="color: red;"/>*</span></p>
    <section>
        <h2>Offer Details</h2>
        <p><label for="image">
                <span>Image: </span> <input type="file" name="image" onchange="uploadImage(this)"> <img src=""
                                                                                                        id="preview"
                                                                                                        style="display: none; height: 70px;">
                <span class="error" id="imageMessage">*</span>
            </label></p>
        <p><label for="category">
                <span>Category: </span>
                <select id="category" name="category">
                    <option value="0">Please select</option>
                    <?php
                    for ($i = 0; $i < count($categories); $i++)
                        echo "<option value='" . $categories[$i] . "'>" . $categories[$i] . "</option>";
                    ?>
                </select>
                <span class="error" id="categoryMessage">*</span>
            </label></p>
        <p><label for="retailPrice">
                <span>Retail Price: </span> <input type="number" id="retailPrice" name="retailPrice" min="0" step=".01">
                <span class="error" id="retailPriceMessage">*</span>
            </label></p>
        <p><label for="offerPrice">
                <span>Offer Price: </span> <input type="number" id="offerPrice" name="offerPrice" min="0" step=".01">
                <span class="error" id="offerPriceMessage">*</span>
            </label></p>
        <p><label for="description">
                <span>Description: </span> <textarea id="description" name="description" cols="40" rows="4"></textarea>
                <span class="error" id="descriptionMessage">*</span>
            </label></p>
    </section>
    <section>
        <h2>Address Details</h2>
        <p><label for="addrStreet">
                <span>Street: </span> <input type="text" id="addrStreet" name="addrStreet">
                <span class="error" id="addrStreetMessage">*</span>
            </label></p>
        <p><label for="addrCity">
                <span>City/Town: </span> <input type="text" id="addrCity" name="addrCity">
                <span class="error" id="addrCityMessage">*</span>
            </label></p>
        <p><label for="addrPostcode">
                <span>Postcode: </span> <input type="text" id="addrPostcode" name="addrPostcode">
                <span class="error" id="addrPostcodeMessage">*</span>
            </label></p>
        <p><label for="area">
                <span>Area: </span>
                <select id="addrArea" name="addrArea">
                    <option value="0">Please select</option>
                    <?php
                    for ($i = 0; $i < count($areas); $i++)
                        echo "<option value='" . $areas[$i] . "'>" . $areas[$i] . "</option>";
                    ?>
                </select>
                <span class="error" id="addrAreaMessage">*</span>
            </label></p>
    </section>
    <p><label><span><button type="button" id="addBtn" name="addBtn"
                            onclick="validate()">Add Order</button></span></label></p>
</form>
<?php
}
?>

</body>
</html>