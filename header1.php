<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wastood - share your food</title>

    <?php
    /*  HEADER used throughout the website with top navigation*/
    session_start();
    ?>
    <link rel="canonical" href="https://startbootstrap.com/previews/small-business/">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-6jHF7Z3XI3fF4XZixAuSu0gGKrXwoX/w3uFPxC56OtjChio7wtTGJWRW53Nhx6Ev" crossorigin="anonymous">
    <link rel="stylesheet" href="startbootstrap-small-business-gh-pages/vendor/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="startbootstrap-small-business-gh-pages/vendor/bootstrap/js/bootstrap.js">

    <script type="f4e646bf5dada19e46bc3c18-text/javascript" src="//m.servedby-buysellads.com/monetization.js"></script>
    <script type="text/javascript" src="startbootstrap-small-business-gh-pages/vendor/jquery/jquery.js"></script>
    <script type="text/javascript" src="startbootstrap-small-business-gh-pages/vendor/jquery/jquery.slim.js"></script>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark position-static">
    <div class="container">
        <a class="navbar-brand" href="home.php">Wastood</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="shop.php">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Add offer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="basket.php"><img src="loyalty-24px.svg" alt=""></img></a>
                </li>
                <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-fw fa-user"></i>
                        </a>
                        <?php
                        echo "<div class='dropdown-menu dropdown-menu-right' aria-labelledby='navbarDropdownMenuLink'>";

                        if(isset($_SESSION['user'])){
                        echo "<a class='dropdown-item' href='logout.php'>Log out</a>";
                        echo "<a class='dropdown-item' href='myAccount.php'> My account</a>";
                    } else {
                            $id = '';
                            $name = '';

                            echo "<li class='nav-item'>";
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
