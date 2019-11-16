<?php
//assigns database details
$servername="devweb2019.cis.strath.ac.uk";
$username="cs312p";
$password="eaQuei6UeFaa";
//connects to my database
try {
    $conn=new PDO("mysql:host=$servername;dbname=cs312p",$username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connection successful";
}
catch  (PDOException $e) {
    echo "Connexion failed" .$e->getMessage();
}