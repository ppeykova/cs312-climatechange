<!DOCTYPE html>
<html>
<?php
require('connect.php');

/*LOG IN PAGE*/
?>
<head><title>Log in</title>

</head>
<body class="login-page sidebar-collapse">
<?php
echo "<div class='page-header header-filter' style='background-image: url('/material-kit-master/assets/img/landing.jpg'); background-size: cover; background-position: center center;'> ";
echo "<div class='container'>";
echo "<div class='row'>";
require('header1.php');
echo  "<div class='col-lg-4 col-md-6 ml-auto mr-auto'>
			<div class='card card-login'>
                <form class='form'  method='POST' action='' name='myform' onsubmit='return checkform();'>
              <div class='card-header card-header-primary text-center'>
                    <h4 class='card-title'>Log in</h4>
              </div>
              <div class='card-body'>
                <div class='input-group'>
                  <input type='email' class='form-control' name='email' placeholder='Email...' required>
                </div>
                <div class='input-group'>
                  <input type='password' class='form-control' name='password' placeholder='Password...' required>
                </div>
              </div>
                <div class='footer text-center'>
                   <input type='submit' value='Log in' name='submit' class='btn btn-primary btn-link btn-wd btn-lg'>
                </div>
              <div class='bmd-form-group'>
                  <p class='text-center'>Forgotten password? <a href='resetpw.php'>Reset your password</a> </p>
                  <p class='text-center'>You have not made an account? Just <a href='signup.php'>sign up</a> now.</p>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>";
//log in


$var=$_GET['var'];
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
        if(empty($var)){
        ?>
        <script>alert("Login successful");
            location.href = "home.php"</script>;
        <?php
        }
        else if($var="basket"){
            ?>
            <script>alert("Login successful");
            location.href = "basket.php"</script>;
         <?php
        }
    }
    else {
        echo "<div class='err'>"; ?>
        <script>alert("Username not found");
        </script>;
<?php
        echo "</div>";
    }

}//end if form button click
?>
<?php
require('footer.php');
?>
</body>
</html