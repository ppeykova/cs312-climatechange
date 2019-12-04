<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="addOffer.js"></script>
    <script>
        var maxPrices = [5, 10, 5, 10, 5, 10, 5, 15, 5, 5];
        function submitForm()
        {
            document.offerForm.submit();
        }
    </script>
    <title>Add Offer</title>
</head>
<body class="profile-page sidebar-collapse">
<div class="page-header header-filter" data-parallax="true" style="background-image: url('material-kit-master/assets/img/greenpic.jpg')">
    <div class="container">
        <?php require('header1.php'); ?>
        <div class="brand text-center">
            <h1>Add an Offer</h1>
        </div>
    </div>
</div>
<div class="main main-raised">
    <div class="container">
        <div class="col-8 ml-auto mr-auto">
            <div class="section">
                <?php
                $_SESSION['output_message'] = "";
                $categories = ["Beans", "Bakery", "Dairy", "Drinks", "Fruit", "Meat", "Nuts", "Ready Meals", "Sweets", "Vegetables"];
                if(!isset($_SESSION['email']))
                {
                    echo "<div class='text-center'>";
                    echo "<p id='loginMessage'>Error: User is not logged in</p><br/>
                  <p>Please <a href='login.php'>Login</a> first.</p>";
                    die();
                    echo "</div>";
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
                    $address = $_POST['addrStreet'].', '.$_POST['addrCity'].', '.$_POST['addrPostcode'];
                    include 'connect.php';
                    $stmt = $conn->prepare("INSERT INTO `products` (`picture`, `category`, `description`, `genprice`, `offprice`, `addr_latitude`, `addr_longitude`, `address`, `email`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    if($stmt->execute([$image, $category, $description, $retailPrice, $offerPrice, $_POST['geocodeLatitude'], $_POST['geocodeLongitude'], $address, $_SESSION['email']]) === true)
                        $_SESSION['output_message'] = "Offer added successfully!";
                    else
                        $_SESSION['output_message'] = "Error: Offer could not be added, please try again...";
                }
                ?>
                <div class="col-md-6 ml-auto mr-auto">
                    <form name="offerForm" method="POST" action="" enctype="multipart/form-data" class="form">

                        <div class="container">
                            <input type="hidden" name="geocodeLatitude" id="geocodeLatitude">
                            <input type="hidden" name="geocodeLongitude" id="geocodeLongitude">
                            <p><?php if(isset($_POST['category'])) { echo $_SESSION['output_message']; } ?></p>
                            <div class="section">
                                <div class="text-center">
                                    <h2>Offer Details</h2>
                                    <p>Required fields marked with <span style="color: red;"/>*</span></p>
                                </div>
                                <p><label for="image">
                                        <span class="form-text">* Upload image: </span><br/><input type="file" class="input-group-btn" id="image" name="image" accept="image/*" onchange="uploadImage(this)" required> <img src="" id="preview" class="card-img">
                                        <span class="error" id="imageMessage"></span>
                                    </label></p>
                                <p><label for="category">
                                        <span class="error" id="categoryMessage">*</span>
                                        <select id="category" name="category" class="custom-select" required>
                                            <option value="0">Please select</option>
                                            <?php
                                            for($i = 0; $i < count($categories); $i++)
                                                echo "<option value='".$categories[$i]."'>".$categories[$i]."</option>";
                                            ?>
                                        </select>
                                    </label></p>
                                <p><label for="retailPrice">
                                        <span class="error" id="retailPriceMessage">*</span>
                                        <input type="number" class="form-control" id="retailPrice" name="retailPrice" min="0" step=".01" placeholder="Retail Price:">
                                    </label></p>
                                <p><label for="offerPrice">
                                        <span class="error" id="offerPriceMessage">*</span>
                                        <input type="number" id="offerPrice" class="form-control" name="offerPrice" min="0" step=".01" placeholder="Offer Price:">
                                    </label></p>
                                <p><label for="description">
                                        <span class="error top" id="descriptionMessage">*</span><br/>
                                        <textarea id="description" name="description" cols="40" rows="4" placeholder="Description:"></textarea>
                                    </label></p>
                            </div>
                        </div>
                        <div class="modal-footer"></div>
                        <div class="section">
                            <div class="text-center">
                                <h2>Address Details</h2>
                            </div>
                            <p><label for="addrStreet">
                                    <span class="error" id="addrStreetMessage">*</span>
                                    <input class="form-control" type="text" id="addrStreet" name="addrStreet" placeholder="Street:">
                                </label></p>
                            <p><label for="addrCity">
                                    <span class="error" id="addrCityMessage">*</span>
                                    <input class="form-control" type="text" id="addrCity" name="addrCity" placeholder="City/Town:">
                                </label></p>
                            <p><label for="addrPostcode">
                                    <span class="error" id="addrPostcodeMessage">*</span>
                                    <input type="text" class="form-control" id="addrPostcode" name="addrPostcode" placeholder="Postcode">
                                </label></p>
                        </div>

                        <p><label><button type="button" id="toHome" name="toHome"  class="btn btn-primary" onclick="window.location.href = 'home.php';">Return to Home</button></label>
                            <label><button type="button" id="addBtn" name="addBtn" class="btn btn-primary" onclick="validate()">Add Offer</button></label></p>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.php');
?>
</body>
</html>
