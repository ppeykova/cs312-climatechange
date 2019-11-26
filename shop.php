<?php
    require('connect.php');

    $categoryType = "";
    $mainArea = "";
    $userLocation = "";
    $userLatitude = "";
    $userLongitude = "";

    if(isset($_POST['category'])) {
        $categoryType = $_POST['category'];
    }
    if(isset($_POST['area'])) {
        $mainArea = $_POST['area'];
    }
    if(isset($_POST['userLatitude'])) {
        $userLatitude = $_POST['userLatitude'];
    }
    if(isset($_POST['userLongitude'])) {
        $userLongitude = $_POST['userLongitude'];
    }
    if(isset($_POST['userLocation'])) {
        $userLocation = $_POST['userLocation'];
    }

    function coordsToDistance($latA, $longA, $latB, $longB)
    {
        $kmsInDeg = 111;
        $avgLat = ($latA + $latB) / 2;

        $deltaLat = abs($latA - $latB) * $kmsInDeg;
        $deltaLong = abs($longA - $longB) * cos($avgLat * (pi() / 180)) * $kmsInDeg;

        $distance = sqrt(($deltaLat * $deltaLat) + ($deltaLong * $deltaLong));
        return $distance;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop</title>
    <script src="shop.js"></script>
    <script>
        function submitForm()
        {
            document.filterForm.submit();
        }
    </script>
</head>
<body>
<?php
        include('header1.php');

        function select(){
            return "SELECT * FROM `products`";
        }
        function selectWhereCategory($categ){
            return 'SELECT * FROM `products` WHERE category = "'.$categ.'"';
        }
        function selectWhereArea($locat){
            return 'SELECT * FROM `products` WHERE area = "'.$locat.'"';
        }
        function selectWhereAndWhere($categor, $location){
            return 'SELECT * FROM `products` WHERE category = "'.$categor.'" AND area = "'.$location.'"';
        }

        function listProducts($array){
            echo "</br>";
            echo "<table>";
            for ($j=0; $j < count($array); $j = $j + 3) {
                echo "<tr>";
                for($c=0; $c < 3; $c++) {
                    if(!empty($array[$j + $c])) {
                        $distance = number_format($array[$j + $c]['distance'], 1);
                        $id = $array[$j + $c]['id'];
                        $image = $array[$j + $c]['picture'];
                        $description = $array[$j + $c]['description'];
                        $price = number_format($array[$j + $c]['offprice'], 2);
                        if($distance != -1) {
                            echo "<div class='col-md-3' style='border-image-width: 15em'>
                              <td class='card-body'><img class='card-img-top' style='max-height: 300px' src='data:image/jpeg;base64," . base64_encode($image) . "'/>" . "<p class='card-text'> $description </p><p class='card-text'> £ $price </p><p id='distance'>$distance km</p> <button class='btn btn-primary' onclick='addToBasket($id)'> Add to basket </button></td></div>";
                        }
                        else {
                            echo "<div class='col-md-3' style='border-image-width: 15em'>
                              <td class='card-body'><img class='card-img-top' style='max-height: 300px' src='data:image/jpeg;base64," . base64_encode($image) . "'/>" . "<p class='card-text'> $description </p><p class='card-text'> £ $price </p><p id='distance'></p> <button class='btn btn-primary' onclick='addToBasket($id)'> Add to basket </button></td></div>";
                        }
                    }
                }
                echo "</tr>";
            }
            echo "</table>";
        }

?>
    </br>
    <div class="container">
        <div class="row">
            <div class="col-md-4 md-5 mx-auto" >
        <form name="filterForm" method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <input type="hidden" name="userLatitude" id="userLatitude">
            <input type="hidden" name="userLongitude" id="userLongitude">
            <select name="category">
        <option value="auto" selected disabled>Sort by Category</option>
        <option value="all" <?php if(isset($_POST["category"]) && $categoryType == "all"){echo "selected";} ?>> All </option>
        <option value="fruit" <?php if(isset($_POST["category"]) && $categoryType == "fruit"){echo "selected";} ?>> Fruit </option>
        <option value="vegetables" <?php if(isset($_POST["category"]) && $categoryType == "vegetables"){echo "selected";} ?>> Vegetables </option>
        <option value="dairy" <?php if(isset($_POST["category"]) && $categoryType == "dairy"){echo "selected";} ?>> Dairy </option>
        <option value="meat" <?php if(isset($_POST["category"]) && $categoryType == "meat"){echo "selected";} ?>> Meat </option>
        <option value="beans" <?php if(isset($_POST["category"]) && $categoryType == "beans"){echo "selected";} ?>> Beans </option>
        <option value="nuts" <?php if(isset($_POST["category"]) && $categoryType == "nuts"){echo "selected";} ?>> Nuts </option>
        <option value="bakery" <?php if(isset($_POST["category"]) && $categoryType == "bakery"){echo "selected";} ?>> Bakery </option>
        <option value="sweets" <?php if(isset($_POST["category"]) && $categoryType == "sweets"){echo "selected";} ?>> Sweets </option>
        <option value="ready_meal" <?php if(isset($_POST["category"]) && $categoryType == "ready_meal"){echo "selected";} ?>> Ready meals </option>
        <option value="drinks" <?php if(isset($_POST["category"]) && $categoryType == "drinks"){echo "selected";} ?>> Drinks </option>
    </select>
    <select name="area" >
        <option value="auto" selected disabled>Sort by Area</option>
        <option value="all" <?php if(isset($_POST["area"]) && $mainArea == "all"){echo "selected";} ?>>All</option>
        <option value="centre" <?php if(isset($_POST["area"]) && $mainArea == "centre"){echo "selected";} ?>>City Centre</option>
        <option value="east" <?php if(isset($_POST["area"]) && $mainArea == "east"){echo "selected";} ?>>East End</option>
        <option value="west" <?php if(isset($_POST["area"]) && $mainArea == "west"){echo "selected";} ?>>West End</option>
        <option value="south" <?php if(isset($_POST["area"]) && $mainArea == "south"){echo "selected";} ?>>South Side</option>
        <option value="north" <?php if(isset($_POST["area"]) && $mainArea == "north"){echo "selected";} ?>>North Glasgow</option>
    </select>
    <input type="text" name="userLocation" id="userLocation" placeholder="Location" value="<?php echo $userLocation; ?>">
    <input type="button" name="submitBtn" value="Filter" class="btn btn-primary" onclick="checkUserLocation()"><span id="userLocationMessage"></span>
        </form>
            </div>
    <div class="mx-auto">
    <?php
        $array = array();

        if((($categoryType == "all") || empty($categoryType)) && (($mainArea == "all") || (empty($mainArea)))) {
            $sql = select();
        } else if(($mainArea == "all") || (empty($mainArea))) {
            $sql = selectWhereCategory($categoryType);
        } else if((($categoryType == "all") || empty($categoryType))) {
            $sql = selectWhereArea($mainArea);
        } else {
            $sql = selectWhereAndWhere($categoryType, $mainArea);
        }

        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed.");
        }

        unset($array);
        $array = array();

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $array[] = $row;
        }

        $distance = [];
        if(!empty($userLatitude) && !empty($userLongitude)) {
            for ($i = 0; $i < $result->rowCount(); $i++) {
                $array[$i]['distance'] = coordsToDistance($userLatitude, $userLongitude, $array[$i]['addr_latitude'], $array[$i]['addr_longitude']);
                $distance[$i] = $array[$i]['distance'];
            }
        }
        $index = [];
        for($i = 0; $i < count($distance); $i++)
        {
            $index[$i] = $i;
        }

        if ($result->rowCount() > 0) {
            array_multisort($distance, $index);
            $sortedArray = array();
            for($i = 0; $i < count($index); $i++)
            {
                $sortedArray[$i] = $array[$index[$i]];
            }
            if(isset($_POST['userLocation']))
                listProducts($sortedArray);
            else
                listProducts($array);
        } else {
            echo "No products available of this criteria. Try again later.";
        }

    ?>
        </div>
        </div>
    </div>
</body>
</html>