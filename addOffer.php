<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="uikit-3.2.3\css\uikit.min.css" />
    <script src="uikit-3.2.3\js\uikit.min.js"></script>
    <script src="uikit-3.2.3\js\uikit-icons.min.js"></script>
    <script src="addOffer.js"></script>
    <style>
        label span
        {
            display: inline-block;
            width: 120px;
            text-align: right;
            padding-right: 20px;
        }
    </style>
    <title>Add Offer</title>
</head>
<body>
    <?php
        $submitted = false;
        $categories = ["Beans", "Bakery", "Dairy", "Drinks", "Fruit", "Meat", "Nuts", "Ready Meals", "Sweets", "Vegetables"];
        $maxPrices = [5, 10, 5, 10, 5, 10, 5, 15, 5, 5];
        $_SESSION['loggedIn'] = true;
        if(!$_SESSION['loggedIn'])
        {
            echo "<p>Error: User is not logged in</p>";
            die();
        }

        if(isset($_POST['category']))
        {
            sendToDB();
        }

        function sendToDB()
        {
            $category = $_POST['category'];
            $retailPrice = $_POST['retailPrice'];
            $offerPrice = $_POST['offerPrice'];
            $description = $_POST['description'];
            $addrStreet = $_POST['addrStreet'];
            $addrCity = $_POST['addrCity'];
            $addrPostcode = $_POST['addrPostcode'];

            // TODO: Connect and send to database
        }
    ?>
    <h1>Add an Offer</h1>
    <br>
    <form name="offerForm" method="POST" action="addOffer.php" onclick="return validate()">
        <p><?php if($submitted) { echo "Offer added successfully!"; } ?></p>
        <section>
            <h2>Offer Details</h2>
            <p><label for="image">
                    <span>Image: </span> <input type="file" id="image" onchange="uploadImage(this)"> <img src="" id="preview" style="height: 70px;">
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
                    <span id="categoryMessage" style="display: none;">No category selected</span>
                </label></p>
            <p><label for="retailPrice">
                    <span>Retail Price: </span> <input type="number" id="retailPrice" name="retailPrice">
                    <span id="retailPriceMessage" style="display: none;">Retail price is required</span>
                </label></p>
            <p><label for="offerPrice">
                    <span>Offer Price: </span> <input type="number" id="offerPrice" name="offerPrice">
                    <span id="offerPriceMessage" style="display: none;">Offer price is required</span>
                </label></p>
            <p><label for="description">
                    <span>Description: </span> <textarea id="description" name="description" cols="40" rows="4"></textarea>
                    <span id="descriptionMessage1" style="display: none;">Description is required</span>
                    <span id="descriptionMessage2" style="display: none;">Description must be less than 255 characters</span>
                </label></p>
        </section>
        <section>
            <h2>Contact Details</h2>
            <p><label for="addrStreet">
                    <span>Street: </span> <input type="text" id="addrStreet" name="addrStreet">
                    <span id="addrStreetMessage" style="display: none;">Street is required</span>
                </label></p>
            <p><label for="addrCity">
                    <span>City/Town: </span> <input type="text" id="addrCity" name="addrCity">
                    <span id="addrCityMessage" style="display: none;">City is required</span>
                </label></p>
            <p><label for="addrPostcode">
                    <span>Postcode: </span> <input type="text" id="addrPostcode" name="addrPostcode">
                    <span id="addrPostcodeMessage" style="display: none;">Postcode is required</span>
                </label></p>
        </section>
        <p><label><span><button type="submit" id="submit">Add Order</button></span></label></p>
    </form>
</body>
</html>
