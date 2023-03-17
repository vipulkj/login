<?php
include 'header.php';
?>
<?php
include 'config.php';

// check login button presed on not

if (isset($_POST['login'])) {
    // $username = $_POST['username_or_email'];
    $email = $_POST['username_or_email'];
    $password = $_POST['password'];
    $incpass = md5($password);

// check field are not empty

    if (empty($email) && empty($password)) {
        echo '<div class="alert alert-danger" role="alert">
        ALL Fields Are Required
      </div>';
    } else {
        $sql = "select * from user where username = '$email' || email = '$email'";             //check if username or email exists
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $row_pass = $row['password'];
            $db_username = $row['username'];
            $db_email = $row['email'];                                                            //checking entered password matched on database
            $is_verify = $row['is_verify'];
            if($is_verify == 1) {
                if ($row_pass === $incpass) {
                    session_start();
                    $_SESSION['username'] = $db_username;                                            //put the value of username in session so page accesed only logined user
                    $_SESSION['email'] = $db_email;                                                                            
                    header('location:index.php');
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                            Wrong Username or Password
                            </div>';
                }
            }else{
                echo '<div class="alert alert-danger" role="alert">
                email not verified check your mail 
                </div>';
            }
            
        }
    }
}

?>


<div class="container ">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                <h1 class="text-center">Login</h1>
                <div class="form-group">
                    <label for="">Username/Email</label>
                    <input type="text" name="username_or_email" placeholder="Username/Email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" placeholder="password" class="form-control">
                </div>

                <div class="form-group my-2">
                    <input type="submit" name="login" class="form-control btn btn-success" >
                </div>
                <div class="form-group my-2">
                    Not have a account <span><a href="register.php">Register</a></span> here<br>
                     <span><a href="forget.php">Forgot Password</a></span> here
                </div>
            </form>
        </div>
    </div>
</div>




<?php
include 'footer.php';
?>