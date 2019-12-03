<?php
require('connect.php');
require('header1.php');
/*ENDING SESSION*/
session_destroy();
echo '<script>alert("You are now logged out");location.href="home.php";</script>';
?>