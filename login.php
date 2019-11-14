<!DOCTYPE html>
<html>
<?php
require('connect.php');

/*LOG IN PAGE*/

?>
<head><title>Log in</title>
    <style>
        .loginform{
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
            margin-bottom: 20px;
            border-color: #4F4F52;
            border-radius: 10px;
            cursor: pointer;
        }
        input[type=email] {
            font-family: sans-serif;
            font-size:20px;
            margin-bottom:30px;
            margin-left: 10px;
            border-radius: 5px;
        }
        input[type=password] {
            font-family: sans-serif;
            font-size:20px;
            margin-bottom:30px;
            margin-left:10px;
            border-radius: 5px;

        }
        label{
            padding-left:10px;
            font-size:20px;
            font-family: sans-serif;
        }
        a:hover{
            color:#9F2D12;
        }
        a{
            color:#000000;
            font-family: sans-serif;
        }
        .log{
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

<?php
echo "<div class='log'>Log in </div>";

echo '<div class="loginform">';
echo "<form method='POST' action=''>
      <label>Email</label><br/>
       <input type='email' name='email' required><br/>
      <label>Password</label><br/>
      <input type='password' name='password' required><br/>
      <input type='submit' name='submit'>
      </form>";
echo "<a href='resetpw.php'>Reset password</a><br/>";
echo '</div>';


//log in
if(isset($_POST['submit'])){

    $email=$_POST['email'];
    /*encryptning password for security purposes*/
    $salt="sfgtjhdtfh658465461";
    $password=sha1($_POST['password'].$salt);

    $stmt=$conn->prepare("SELECT * FROM users WHERE email =:email AND password=:password ");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if($stmt->rowCount()>0) {

        echo "<p>Login successful";
        if ($email == "cara@cara.com") {
            $_SESSION['email'] = $email;

        }

            ?>
            <script>alert("Login successful");
                location.href = "listart.php"</script>;
            <?php
    }
    else {
        echo "<div class='err'>";
        echo "<p>Login failed!</p>";
        echo "</div>";
    }
}//end if form button click
?>
</body>
</html