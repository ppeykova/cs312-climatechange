<!DOCTYPE html>
<html>
<?php
require('connect.php');
require('header1.php');

/*LOG IN PAGE*/

?>
<head><title>Log in</title>

</head>
<body>

<?php
echo "<div class='container p-lg-5'>";
echo "<div class='row'>";
echo "<div class='col-md-5 mx-auto'>
			<div class='form-control-plaintext'>";
echo "<div class='col-md-12 text-center'>
      <h1>Log in</h1></div>";

echo "<form method='POST' action=''>
      <div class='form-group'>
      <label for='exampleInputEmail1'>Email</label>
      <input type='email' name='email' class='form-control' id='exampleInputEmail1' placeholder='Enter email' required>
      </div>
      <div class='form-group'>
      <label for='exampleInputPassword1'>Password</label>
      <input type='password' name='password' class='form-control' id='exampleInputPassword1'  placeholder='Password' required>
      </div>
      <div class='text-center'>
      <button type='submit' name='submit' class='btn btn-block mybtn btn-primary tx-tfm'>Log in</button>
      </div>
      </form><br/>";
echo "<div class='form-group'>
    <div class='col-md-12 md-5 mx-auto'>
        <p class='text-center'>Forgotten password? <a href='resetpw.php'>Reset your password</a> </p>
        <p class='text-center'>You have not made an account? Just <a href='signup.php'>sign up</a> now.</p>
    </div>
    </div>";
echo '</div>
    </div>
    </div>
    </div>
    </div>';



//log in
if(isset($_POST['submit'])){

    $email=$_POST['email'];
    /*encryptning password for security purposes*/
    $salt="sfgtjhdtfh658465461";
    $password=sha1($_POST['password'].$salt);

    $stmt=$conn->prepare("SELECT * FROM `users` WHERE `email` =:email AND `password`=:password ");
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    if($stmt->rowCount()>0) {

        echo "<p>Login successful";

            $_SESSION['email'] = $email;
            $_SESSION['user'] = true;
            ?>
            <script>alert("Login successful");
                location.href = "home.php"</script>;
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