<?php
include 'header.php';
?>

<?php
include 'config.php';
?>

<?php

session_start();
header("location: index.php");

session_unset();


session_destroy();

?>


<?php
include 'footer.php';
?>