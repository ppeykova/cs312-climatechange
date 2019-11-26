<!DOCTYPE html>
<html>
<?php
require('connect.php');
require('header1.php');
/*RESET PASSWORD PAGE*/
?>
<head>
    <title>Reset password</title>
    <style>
        .resetform{
            border-radius: 6px;
            background-color: #f2f2f2;
            margin-left:20px;
            margin-top:40px;
            padding-top: 40px;
            padding-left:20px;
            padding-right:40px;
            padding-bottom:10px;
            float: left;
        }
        input[type=submit] {
            font-size:15px;
            background-image:linear-gradient(#FFFFFF, #DBB5AB, #D1ACA3,#BF9E95);
            color: white;
            padding: 5px 10px;
            margin-left:80px;
            border-color: #4F4F52;
            border-radius: 10px;
            cursor: pointer;
        }

        input[type=email] {
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
        .reset{
            padding-left:50px;
            font-family: sans-serif;
            font-size:40px;
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
    //checks length of variables
    function checkform(){

        var email = document.forms["myform"]["email"];
        var password = document.forms["myform"]["password"];
        var pass1 = document.forms["myform"]["password1"];

        var errs = "";


        if(email.value.length > 50){
            errs += " Wrong email!\n";
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

echo "<div class='reset'>Reset password </div>";

echo "<div class='resetform' >";
echo "<form method='POST' action='' name='myform' onsubmit='return checkform();'>
<label>Email</label><br/>
    <input type='email' name='email' required><br/>
<label>New password</label><br/>
<input type='password' name='password' required><br/>
<label>Confirm password</label><br/>
<input type='password' name='password1' required><br/>
  <input type='submit' value='Submit' name='submitreset'>
  </form>
";
echo "</div>";
?>

<?php
//reset
if(isset($_POST['submitreset'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];
    $password1 = $_POST['password1'];

    if($password != $password1 ) {
        echo "<div class='err'>";
        echo "Passwords don't match!";
        echo "</div>";
    }
    else{
        if(strlen($password) < 8){
            echo "Password must contain a minimum of 8 characters";
        }
        else {
            //encryption of password for security purposes
            $salt="sfgtjhdtfh658465461";
            $password=sha1($_POST['password'].$salt);

            echo "email: " . $email . " and pw : " . $password;

            $stmt = $conn->prepare("UPDATE users SET password =:password  WHERE email=:email");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            if ($stmt->execute()) {
                ?>
                <script>alert("password reset");
                    location.href = "home.php"</script>
                <?php
            }
        }
    }
}
?>
</body>
</html>