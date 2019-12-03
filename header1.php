<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wastood - share your food</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport'>
    <?php
    /*  HEADER used throughout the website with top navigation*/
    session_start();
    ?>

    <!---Material Kit --->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-6jHF7Z3XI3fF4XZixAuSu0gGKrXwoX/w3uFPxC56OtjChio7wtTGJWRW53Nhx6Ev" crossorigin="anonymous">

    <link href="material-kit-master/assets/css/material-kit.css?v=2.0.6" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">

    <script src="material-kit-master/assets/js/core/jquery.min.js" type="text/javascript"></script>
    <script src="material-kit-master/assets/js/core/popper.min.js" type="text/javascript"></script>
    <script src="material-kit-master/assets/js/core/bootstrap-material-design.min.js" type="text/javascript"></script>
    <script src="material-kit-master/assets/js/plugins/moment.min.js"></script>
    <script src="material-kit-master/assets/js/plugins/bootstrap-datetimepicker.js" type="text/javascript"></script>
    <script src="material-kit-master/assets/js/plugins/nouislider.min.js" type="text/javascript"></script>
   <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
-->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js"></script>

</head>
<body class="landing-page sidebar-collapse">
<nav class="navbar navbar-transparent navbar-color-on-scroll fixed-top navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
    <div class="container">
        <div class="navbar-translate">
            <a class="navbar-brand" href="home.php"><h1>Wastood</h1></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="sr-only">Toggle navigation</span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shop.php">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="addOffer.php">Add offer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="basket.php">
                        <i class="material-icons">add_shopping_cart</i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">person</i>
                        <div class="ripple-container"></div>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?php
                        if(isset($_SESSION['user'])){
                            echo "<a class='dropdown-item' href='logout.php'>Log out</a>";
                            echo "<a class='dropdown-item' href='myAccount.php'> My account</a>";
                        } else {
                            $var = '';
                            $email = '';
                            echo "<a class='dropdown-item' href='login.php?var=".$var."&email=".$email."'>Login</a>";
                            echo "<a class='dropdown-item' href='signup.php?var=".$var."&email=".$email."'>Sign up</a>";
                        }
                        ?>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
</body>
</html>