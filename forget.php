

<?php
require 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $reset_token)
{
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/SMTP.php';

    $phpmailer = new PHPMailer(true);

try {
    
    // $phpmailer = new PHPMailer();
    $phpmailer->isSMTP();
    $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = 'username';
    $phpmailer->Password = 'password';

    //Recipients
    $phpmailer->setFrom('email', 'VIP WEB');

    $phpmailer->addAddress($email);     //Add a recipient
    
    //Content
    $phpmailer->isHTML(true);                                  //Set email format to HTML
    $phpmailer->Subject = 'Password Reset Link';
    $phpmailer->Body    = "We get a request from you to reset your password <br>
        Click the link below: <br>
        <a href='http://localhost/login-form/update-password.php?email=$email&reset_token=$reset_token'>Reset Password</a>
    ";

    $phpmailer->send();
    return true;
} catch (Exception $e) {
    return false;
}

}


if (isset($_POST['reset-password'])) {

    $email = $_POST['email'];

    if (empty($email)) {
        echo '<div class="alert alert-danger" role="alert">
                Email Required
                </div>';
    } else {
        $query = "select * from user where email = '$email'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $reset_token = bin2hex(random_bytes(16));
                date_default_timezone_set('Asia/kolkata');
                $date = date('Y-m-d');
                echo $date;
                $query1 = "UPDATE `user` SET `reset_token`='$reset_token',`token_expire`='$date' WHERE email = '$email'";
                if (mysqli_query($conn, $query1) && sendMail($email,$reset_token)) {
                    echo '<div class="alert alert-danger" role="alert">
                Password Reset Link Send to email
                </div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">
                Server Down
                </div>';
                }
            } else {
                echo '<div class="alert alert-danger" role="alert">
            Invalid Email
            </div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">
        Cannot Run Query
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
                <h1 class="text-center">Reset Password</h1>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="text" name="email" placeholder="Email" class="form-control">
                </div>
                <div class="form-group my-2">
                    <input type="submit" name="reset-password" class="form-control btn btn-success" value="Send Link">
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