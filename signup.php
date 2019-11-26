
<?php
require('connect.php');
/*REGISTRATION*/
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
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
<body  class="login-page sidebar-collapse">
<?php
echo "<div class='page-header header-filter' style='background-image: url('/material-kit-master/assets/img/landing.jpg'); background-size: cover; background-position: center center;'>    
    <div class='container'>
      <div class='row'>";
require('header1.php');
echo  "<div class='col-lg-4 col-md-6 ml-auto mr-auto'>
          <div class='card card-login'>
            <form class='form'  method='POST' action='' name='myform' onsubmit='return checkform();'>
              <div class='card-header card-header-primary text-center'>
                <h4 class='card-title'>Register</h4>
                </div>
              <div class='card-body'>
                <div class='input-group'>
                  <input type='text' class='form-control' placeholder='Name...' required>
                </div>
                <div class='input-group '>
                  <input type='email' class='form-control' placeholder='Email...' required>
                </div>
                <div class='input-group'>
                  <input type='password' class='form-control' placeholder='Password...' required>
                </div>
                <div class='input-group'>
                  <input type='password' class='form-control' placeholder=' Confirm password...' required>
                </div>
              </div>
              <div class='footer text-center'>
                <input type='submit' value='Register' class='btn btn-primary btn-link btn-wd btn-lg'></input>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>";
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
<?php
require('footer.php');
?>
</body>
</html>