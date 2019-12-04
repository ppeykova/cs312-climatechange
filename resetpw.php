
<!DOCTYPE html>
<html>
<?php
require('connect.php');
?>
<head>
    <title>Reset password</title>
</head>
<body class="login-page sidebar-collapse">
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
echo "<div class='page-header header-filter' style='background-image: url('/material-kit-master/assets/img/landing.jpg'); background-size: cover; background-position: center center;'>    
    <div class='container'>
      <div class='row'>";
require('header1.php');
echo  "<div class='col-lg-4 col-md-6 ml-auto mr-auto'>
          <div class='card card-login'>
            <form class='form'  method='POST' action='' name='myform' onsubmit='return checkform();'>
              <div class='card-header card-header-primary text-center'>
                <h4 class='card-title'>Reset password</h4>
              </div>
              <div class='card-body'>
              <div class='input-group '>
                <input type='email' class='form-control' name='email' placeholder='Email...' required>
              </div>
              <div class='input-group'>
                <input type='password' class='form-control' name='password' placeholder='New password...' required>
              </div>
              <div class='input-group'>
                <input type='password' class='form-control' name='password1' placeholder=' Confirm new password...' required>
              </div>
              </div>
              <div class='footer text-center'>
                <input type='submit' value='Reset' name='submitreset' class='btn btn-primary btn-link btn-wd btn-lg'>
              </div>
            </form>
         </div>";
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
echo "</div>
    </div>
    </div>";
?>
<?php
require('footer.php');
?>
</body>
</html>
