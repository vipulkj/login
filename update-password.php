<?php
require 'header.php';
?>




<?php
require 'config.php';

$email = $_GET['email'];
$resettoken = $_GET['reset_token'];

if (isset($_GET['email']) && isset($_GET['reset_token'])) {

    date_default_timezone_set('Asia/kolkata');                                     // set timezone                                     
    $date = date('Y-m-d');
    $query = "select * from user where email = '$email' AND reset_token ='$resettoken' AND token_expire = '$date'";           // select user values if has reset_token
    $result = mysqli_query($conn, $query);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            session_start();
            $_SESSION['email'] = $row['email'];
            header('location:reset-password.php');
        } else {
            echo '<div class="alert alert-danger" role="alert">
                Invalid or Expired Link
                </div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">
                Somthing Wrong
                </div>';
    }
}


?>







<?php
require 'footer.php';
?>