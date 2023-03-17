
<?php

require 'config.php';


if(isset($_POST['update']))
{
    session_start();
    $email = $_SESSION['email'];
    $password = $_POST['password'];
    $inc_pass = md5($password);
    $query = "UPDATE `user` SET `password`='$inc_pass',`reset_token`='null',`token_expire`='null' WHERE email = '$email'";      // update password
    $result = mysqli_query($conn,$query);                                                                                       // and reset the token value
    if($result){
        echo '<div class="alert alert-primary" role="alert">
        password updated successfully
        </div>';
    }else{
        echo '<div class="alert alert-danger" role="alert">
        Something went wrong
        </div>';
    }
}


?>



<?php
require 'header.php';
?>

<div class="container ">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <h1 class="text-center">Enter New Password</h1>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" placeholder="Enter New Password" class="form-control">
                </div>
                <div class="form-group my-2">
                    <input type="submit" name="update" class="form-control btn btn-success" value="Update Password">
                </div>
                <div class="form-group my-2">
                    Go Back To <span><a href="login.php">Login</a></span>
                </div>
        </div>
        </form>
    </div>
</div>
</div>




<?php
require 'footer.php';
?>