<?php
require('connect.php');
/*REGISTRATION*/
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        .registerform{
            border-radius: 6px;
            background-color: #f2f2f2;
            margin-left:20px;
            margin-top:40px;
            padding-top: 40px;
            padding-left:20px;
            padding-right:40px;
            padding-bottom: 10px;
            float: left;

        }
        input[type=submit] {
            font-size:15px;
            background-image:linear-gradient(#FFFFFF, #DBB5AB, #D1ACA3,#BF9E95);
            color: white;
            padding: 5px 10px;
            margin-left:100px;
            border-color: #4F4F52;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type=email] {
            font-family: sans-serif;
            font-size:20px;
            margin-bottom:30px;
            margin-left:20px;
            border-radius: 5px;

        }

        input[type=text] {
            font-family: sans-serif;
            font-size:20px;
            margin-bottom:30px;
            margin-left:20px;
            border-radius: 5px;

        }

        input[type=password] {
            font-family: sans-serif;
            font-size:20px;
            margin-bottom:30px;
            margin-left:20px;
            border-radius: 5px;

        }
        label{
            padding-left:20px;
            font-size:20px;
            font-family: sans-serif;

        }

        .reg{
            padding-left:50px;
            font-family: sans-serif;
            font-size:50px;
            padding-top:30px;
        }
        .err{

            color:red;
            font-family: sans-serif;
            font-size: 20px;
        }
    </style>
</head>
<body>
<script>
        //error checks
        function checkform(){

            var email = document.forms["myform"]["email"];
            var password = document.forms["myform"]["password"];
            var pass1 = document.forms["myform"]["password2"];

            var errs = "";


            if(email.value.length > 50){
                errs += " Email cannot more than 50 characters long!\n";
                password.style.background = "pink";
            }

            if(password.value.length > 50 || password.value.length < 8){
                errs += " Password must between 8 and 50 characters long!\n";
                password.style.background = "pink";
            }

            if(pass1.value.length < 8 || pass1.value.length > 50){
                errs += " Password must between 8 and 50 characters long!\n"
                pass1.style.background = "pink";
            }

            if(errs!=""){
                alert(errs);
            }

            return (errs == "");

        }
    </script>

<?php


echo "<div class='reg'>Register </div>";

echo "<div class='registerform' >";
echo "<form method='POST' action='' name='myform' onsubmit='return checkform();'>
      <label>Name</label><br/>
      <input type='text' name='name' required><br/>
      <label>Email</label><br/>
      <input type='email' name='email' required><br/>
      <label>Password</label><br/>
      <input type='password' name='password' id='password' required><br/>
      <label>Confirm password</label><br/>
      <input type='password' name='password2' id='password2' required><br/>
      <input type='submit' value='Submit' name='submit'>
      </form>";

echo "</div>";


if(isset($_POST['submit'])){

    //allocating data forms into variables
    $name       =$_POST['name'];
    $email      =$_POST['email'];
    $password   =$_POST['password'];
    $pw2=        $_POST['password2'];



    $stmt=$conn->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->bindParam(":email",$email);
    $stmt->execute();

    if($stmt->rowCount()>0){

        echo "An account associated with this email has already been created.";

    }
    else {

        if ($password != $pw2) {
            echo "<div class='err'>";
            echo "Passwords don't match!";
            echo "</div>";
        } else {
            $salt="sfgtjhdtfh658465461";
            $password=sha1($password.$salt);


            //insert into database
            $stmt = $conn->prepare("INSERT INTO users(name, email, password) VALUES (:name, :email, :password)");

            //binding parameters
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);


            if ($stmt->execute()){

               $_SESSION['email'] = $email;
             ?>
                <script>alert("Account created!");location.href = "home.php";</script>
            <?php

            }//end if executed

            else { //if not executed

            ?>
                <script>alert("Sign up failed");</script>
                <?php

            }// end else
        }
    }

}//end if form button click
?>
</body>
</html>

