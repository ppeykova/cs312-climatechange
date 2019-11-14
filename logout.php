
<?php
require('connect.php');
//require('header.php');

/*ENDING SESSION*/

session_destroy();


echo '<script>alert("You are now logged out");location.href="home.php";</script>';
//require('footer.php');
