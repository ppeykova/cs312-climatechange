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
        var maxPrices = [5, 10, 5, 10, 5, 10, 5, 15, 5, 5];
        function submitForm()
        {
            document.offerForm.submit();
        }
    </script>
    <style>
        body
        {
            margin-left: 50px;
        }
        label span
        {
            display: inline-block;
            width: 120px;
            text-align: right;
            padding-right: 20px;
        }
        .error
        {
            color: red;
            width: auto;
        }
    </style>
    <title>Add Offer</title>
</head>
<body>
<div>
    <?php include('header1.php'); ?>
</div>
<?php
$_SESSION['output_message'] = "";
$categories = ["Beans", "Bakery", "Dairy", "Drinks", "Fruit", "Meat", "Nuts", "Ready Meals", "Sweets", "Vegetables"];
if(!isset($_SESSION['email']))
{
    echo "<p id='loginMessage'>Error: User is not logged in</p>";
    die();
}
if(isset($_POST['category']))
{
    sendToDB();
}
function sendToDB()
{
    if(!empty($_FILES['image']['tmp_name']))
        $image = file_get_contents($_FILES['image']['tmp_name']);
    else
        $image = "";
    $category = $_POST['category'];
    $retailPrice = $_POST['retailPrice'];
    $offerPrice = $_POST['offerPrice'];
    $description = $_POST['description'];
    echo $_POST['geocodeLatitude'].", ".$_POST['geocodeLongitude'];
    $address = $_POST['addrStreet'].', '.$_POST['addrCity'].', '.$_POST['addrPostcode'];
    include 'connect.php';
    $stmt = $conn->prepare("INSERT INTO `products` (`picture`, `category`, `description`, `genprice`, `offprice`, `addr_latitude`, `addr_longitude`, `address`, `email`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if($stmt->execute([$image, $category, $description, $retailPrice, $offerPrice, $_POST['geocodeLatitude'], $_POST['geocodeLongitude'], $address, $_SESSION['email']]) === true)
        $_SESSION['output_message'] = "Offer added successfully!";
    else
        $_SESSION['output_message'] = "Error: Offer could not be added, please try again...";
}
?>
<h1>Add an Offer</h1>
<form name="offerForm" method="POST" action="" enctype="multipart/form-data">
    <input type="hidden" name="geocodeLatitude" id="geocodeLatitude">
    <input type="hidden" name="geocodeLongitude" id="geocodeLongitude">
    <p><?php if(isset($_POST['category'])) { echo $_SESSION['output_message']; } ?></p>
    <p>Required fields marked with <span style="color: red;"/>*</span></p>
    <section>
        <h2>Offer Details</h2>
        <p><label for="image">
                <span>Image: </span> <input type="file" id="image" name="image" accept="image/*" onchange="uploadImage(this)"> <img src="" id="preview" style="display: none; height: 70px;">
                <span class="error" id="imageMessage">*</span>
            </label></p>
        <p><label for="category">
                <span>Category: </span>
                <select id="category" name="category">
                    <option value="0">Please select</option>
                    <?php
                    for($i = 0; $i < count($categories); $i++)
                        echo "<option value='".$categories[$i]."'>".$categories[$i]."</option>";
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
    </section>
    <p><label><button type="button" id="toHome" name="toHome" onclick="window.location.href = 'home.php';">Return to Home</button></label>
        <label><button type="button" id="addBtn" name="addBtn" onclick="validate()">Add Offer</button></label></p>
</form>
</body>
</html>