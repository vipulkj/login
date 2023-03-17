<?php
include "config.php";

session_start();


if (!isset($_SESSION['username'])) {
    if (!isset($_SESSION['email'])) {
        header('location:login.php');
    }
}

?>
<?php
include "header.php";
?>
<div class="container">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                </ul>
                <ul>
                    <li class="nav-item">
                    </li>
                </ul>
                <a href="logout.php"><button class="btn btn-danger">Logout</button></a>
            </div>
        </div>
    </nav>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="jumbotron">
                <h1 class="display-4 text-primary text-center">Hello <?php  echo $_SESSION['username']; ?></h1>
            </div>
        </div>
    </div>
</div>

<?php
include "footer.php";
?>