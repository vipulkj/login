<?php

require 'config.php';


// email verification

if(isset($_GET['email']) && isset($_GET['verify_code']))      
{
    $email = $_GET['email'];
    $verify = $_GET['verify_code'];

    $query = "select * from user where email='$email' and varification_code='$verify'";
    $result = mysqli_query($conn, $query);
    if($result)
    {
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            if($row['is_verify'] == 0)                                                                          // check is email alreay verified or not
            {
                $email = $row['email'];
                $query1 = "update user set is_verify = '1' where email = '$email'";                             // update email
                if(mysqli_query($conn,$query1)){
                    echo '<div class="alert alert-primary" role="alert">
                    Email verification successful
                    </div>';
                }else
                {
                    echo '<div class="alert alert-danger" role="alert">
                    Email verification failed
                    </div>';
                }
            }
            else{
                echo '<div class="alert alert-danger" role="alert">
                Email already verified
                </div>';
            }
        }else
        {
            echo '<div class="alert alert-danger" role="alert">
            No records found
            </div>';
        }
    }
    else
    {
        echo '<div class="alert alert-danger" role="alert">
        Cannot run query
        </div>';
    }
}

?>