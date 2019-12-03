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

<body class="profile-page sidebar-collapse">
<div class="page-header header-filter" data-parallax="true" style="background-image: url('material-kit-master/assets/img/muffin1.jpg')">
    <div class="container">
        <?php
        require('header1.php');
        ?>
        <div class="col-md-8 ml-auto mr-auto">
            <div class="brand text-center">
                <h1>Shop</h1>
            </div>
        </div>
    </div>
</div>
<div class="main main-raised">
    <div class="container">
        <div class="section text-center">
            <div class="row">
                <div class="col-8 ml-auto mr-auto ">

                    <?php
                    function select(){
                        return "SELECT * FROM `products`";
                    }
                    function selectWhereCategory($categ){
                        return 'SELECT * FROM `products` WHERE category = "'.$categ.'"';
                    }
                    function listProducts($array){
                        echo "<div class='table-responsive'>";
                        echo "<table class='table'>";
                        $height = 200;
                        $width = 200;
                        for ($j=0; $j < count($array); $j = $j + 3) {
                            echo "<tr>";
                            echo "<div class='col'>";
                            for($c=0; $c < 3; $c++) {
                                if(!empty($array[$j + $c])) {
                                    $distance = number_format($array[$j + $c]['distance'], 1);
                                    $id = $array[$j + $c]['id'];
                                    $image = $array[$j + $c]['picture'];
                                    $description = $array[$j + $c]['description'];
                                    $genPrice = number_format($array[$j + $c]['genprice'], 2);
                                    $price = number_format($array[$j + $c]['offprice'], 2);
                                    $address = $array[$j + $c]['address'];
                                    $address = str_replace(' ', '+', $address);
                                    $url ="https://maps.google.com.au/maps?q=". $address;
                                    if($distance != -1) {
                                        echo "<div class='card' style='width: 20rem;'>
                              <td><img class='card-img-top' style='max-height: 300px;' src='data:image/jpeg;base64," . base64_encode($image) . "'/>" . "<div class='card-body'><p class='card-text'> $description </p><del class='card-text'> Originally: £ $genPrice </del></p><p class='card-text'> Now: £ $price </p><p id='distance'>$distance km</p>  <a href=$url onclick=\"return !window . open(this . href, 'Google', 'width=800,height=800')\" target=\"_blank\"> View location map </a>  <button class='btn btn-primary' onclick='addToBasket($id)'> Add to basket </button></div></div></td>";
                                    }
                                    else {
                                        echo "<div class='card' style='width: 20rem;'>
                              <td><img class='card-img-top' style='max-height: 300px;' src='data:image/jpeg;base64," . base64_encode($image) . "'/>" . "<div class='card-body'><p class='card-text'> $description </p><del class='card-text'> Originally: £ $genPrice </del></p><p class='card-text'> Now: £ $price </p><p id='distance'></p> <a href=$url onclick=\"return !window . open(this . href, 'Google', 'width=800,height=800')\" target=\"_blank\"> View location map </a> <button class='btn btn-primary' onclick='addToBasket($id)'> Add to basket </button></div></div></td>";
                                    }
                                }
                            }
                            echo "</div>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        echo "</div>";
                    }
                    ?>
                    </br>
                    <div class="col-4 ml-auto mr-auto" >
                        <form name="filterForm" method='post' action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <div class="align-content-between">
                                <input type="hidden" name="userLatitude" id="userLatitude">
                                <input type="hidden" name="userLongitude" id="userLongitude">
                                <div class="bmd-form-group">
                                    <select name="category" class="custom-select">
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
                                </div>
                                <div class="bmd-form-group input-group">
                                    <input type="text" name="userLocation" id="userLocation" class="form-control" placeholder="Location" value="<?php echo $userLocation; ?>">
                                </div>
                                <input type="button" name="submitBtn" value="Filter" class="btn btn-primary" onclick="checkUserLocation()"><span id="userLocationMessage"></span>
                            </div>
                        </form>
                    </div>
                    <div class="mx-auto">
                        <?php
                        $array = array();

                        if(($categoryType == "all") || empty($categoryType)) {
                            $sql = select();
                        } else {
                            $sql = selectWhereCategory($categoryType);
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
                            if(!empty($userLatitude) && !empty($userLongitude)) {
                                array_multisort($distance, $index);
                                $sortedArray = array();
                                for($i = 0; $i < count($index); $i++)
                                {
                                    $sortedArray[$i] = $array[$index[$i]];
                                }
                                listProducts($sortedArray);
                            }
                            else {
                                listProducts($array);
                            }
                        } else {
                            echo "No products available of this criteria. Try again later.";
                        }
                        ?>
                    </div>
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