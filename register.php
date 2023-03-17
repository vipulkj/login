<?php
include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $verify_code)
{
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    $mail = new PHPMailer(true);

    try {

        // $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'username';
        $mail->Password = 'password';


        //Recipients
        $mail->setFrom('email', 'VIP WEB');
        $mail->addAddress($email);     //Add a recipient


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Email Verification from VIP WEB';
        $mail->Body    = "Thanks for registration!<br>
    Click the link below to verify the email address<br>
    <a href='http://localhost/login-form/verify-email.php?email=$email&verify_code=$verify_code'>Verify Email</a>
    ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}


// checking button presed or not

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // query for checking username or email exist or not

    $check = "select * from user where username = '$username' || email = '$email'";
    $check_run = mysqli_query($conn, $check);

    // check all field are to be filled in

    if (empty($name) || empty($username) || empty($email) || empty($password) || empty($cpassword)) {
        echo '<div class="alert alert-danger" role="alert">
        All Fields Are Required
      </div>';
    } else if ($password != $cpassword) {                           //check password and confirm password are matched or not
        echo '<div class="alert alert-danger" role="alert">
         Password are not Matched
      </div>';
    } else if (mysqli_num_rows($check_run) > 0) {
        echo '<div class="alert alert-danger" role="alert">
        Username and Email Already Exists
      </div>';
    } else {
        // $pass = crypt($password,'$2a$09$');
        $pass = md5($password);                                                                                        //crypt the password

        $verify_code = bin2hex(random_bytes(16));

        $sql1 = "insert into user (name,username, email, password,varification_code,is_verify) values('$name','$username','$email','$pass','$verify_code','0')";     //save data from database

        if (mysqli_query($conn, $sql1) && sendMail($email, $verify_code)) {
            echo '<div class="alert alert-primary" role="alert">
        Register successfully
        </div>';
        } else {
            echo '<div class="alert alert-primary" role="alert">
                Server Down
        </div>';
        }
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
                <h1 class="text-center">Register</h1>
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" placeholder="Name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" name="username" placeholder="Username" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" placeholder="Email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" placeholder="Password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Confirm Password</label>
                    <input type="password" name="cpassword" placeholder="Confirm Password" class="form-control">
                </div>
                <div class="form-group my-2">
                    <input type="submit" name="register" class="form-control btn btn-success" value="Register">
                </div>
                <div class="form-group my-2">
                    Already have a account <span><a href="login.php">Login</a></span>
                </div>
            </form>
        </div>
    </div>
</div>





<?php
include 'footer.php';
?>