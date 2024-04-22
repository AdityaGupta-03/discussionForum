<?php

function isPageActive($page)
{
    $site = basename($_SERVER['PHP_SELF']);

    if ($site == $page) {
        return "active";
    } else {
        return "";
    }
}

?>

<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="../"><img src="/addy/Forums/images/logo.svg" alt="logo" height="30" width="40"> Discussion</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav nav-underline">
                <li class="nav-item">
                    <a class="nav-link <?php echo isPageActive("index.php") ?>" aria-current="page" href="/addy/Forums/index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isPageActive("about.php") ?>" href="/addy/Forums/src/about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo isPageActive("contactus.php") ?>" href="/addy/Forums/src/contactus.php">Contactus</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Top Categories
                    </a>
                    <ul class="dropdown-menu">
                        <?php 
                            $sql = "SELECT category_id, category_name FROM $catTable limit 5";
                            $result = $conn->query($sql);
                            while($row = $result->fetch_assoc()){
                                echo '<li><a class="dropdown-item" href="/addy/Forums/src/threads.php?catid='.$row['category_id'].'">'.$row['category_name'].'</a></li>';
                            }
                        ?>
                    </ul>
                </li>
            </ul>

            <form class="d-flex" role="search" method="GET" action="/addy/Forums/src/search.php">
                <input class="form-control me-2" name="query" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>

            <?php
            session_start();
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
                $username = $_SESSION['username'];
                echo ' <a href="/addy/Forums/components/_logout.php" class="btn btn-outline-warning mx-2">Logout</a>
                <span class="text-light mx-2">Welcome '. $username .'</span>';
            } else {
                echo '<button class="btn btn-outline-warning mx-2" type="button" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</button>
                    <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>';
            }

            ?>
        </div>
    </div>
</nav>

<?php

include("_signupModal.php");
include("_loginModal.php");

if( (isset($_GET['signup']) && $_GET['signup']==true) || (isset($_GET['login']) && $_GET['login']==true) ){
    echo "<div class='alert alert-success alert-dismissible fade show mb-0' role='alert'>
            <strong>Success! </strong> ". $_GET['msg'] ."
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
}
else if ( (isset($_GET['signup']) && $_GET['signup']==false) || (isset($_GET['login']) && $_GET['login']==false) ){
    echo "<div class='alert alert-danger alert-dismissible fade show mb-0' role='alert'>
            <strong>Error! </strong> ". $_GET['msg'] ."
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
}

?>