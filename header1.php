<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wastood - share your food</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport'>
    <?php
    /*  HEADER used throughout the website with top navigation*/
    session_start();
    ?>
    <!--<script src="//m.servedby-buysellads.com/monetization.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="startbootstrap-small-business-gh-pages/vendor/jquery/jquery.js"></script>
    <script src="startbootstrap-small-business-gh-pages/vendor/jquery/jquery.slim.js"></script>

    <link rel="canonical" href="https://startbootstrap.com/previews/small-business/">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-6jHF7Z3XI3fF4XZixAuSu0gGKrXwoX/w3uFPxC56OtjChio7wtTGJWRW53Nhx6Ev" crossorigin="anonymous">
    <link rel="stylesheet" href="startbootstrap-small-business-gh-pages/vendor/bootstrap/js/bootstrap.js" media="all">
    <link rel="stylesheet" href="startbootstrap-small-business-gh-pages/vendor/bootstrap/css/bootstrap.css" media="all">  --->

    <!---Material Kit --->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-6jHF7Z3XI3fF4XZixAuSu0gGKrXwoX/w3uFPxC56OtjChio7wtTGJWRW53Nhx6Ev" crossorigin="anonymous">

    <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
    <script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>

</head>
<body class="landing-page sidebar-collapse">
<nav class="navbar navbar-transparent navbar-color-on-scroll position-static navbar-expand-lg" color-on-scroll="100" id="sectionsNav">
    <div class="container">
        <a class="navbar-brand" href="home.php"><h1>Wastood</h1></a>
        <button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span> </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shop.php">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Add offer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="basket.php">
                        <i class="material-icons">basket</i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-fw fa-user"></i>
                            <div class="ripple-container"></div>

                        </a>
                        <?php
                        echo "<div class='dropdown-menu' aria-labelledby='navbarDropdownMenuLink'>";

                        if(isset($_SESSION['user'])){
                        echo "<a class='dropdown-item' href='logout.php'>Log out</a>";
                        echo "<a class='dropdown-item' href='myAccount.php'> My account</a>";
                    } else {
                            $id = '';
                            $name = '';
                        echo "<a class='dropdown-item' href='login.php?id=".$id."&name=".$name."'>Login</a>";
                        echo "<a class='dropdown-item' href='signup.php?id=".$id."&name=".$name."'>Sign up</a>";

                    }
                        echo "</div>";
                        ?>

                </li>
            </ul>
        </div>
    </div>
</nav>
</body>
</html>
