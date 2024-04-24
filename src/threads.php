<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php
    include("../components/_database.php");
    include("../components/_navbar.php");
    ?>

    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Insert the thread into thread table
        $th_title = $_POST['thread_title'];
        $th_desc = $_POST['thread_description'];
        $catID = $_GET['catid'];

        // I want to prevent the user form the XSS attack 
        // Replace characters that have special meaning in HTML
        $escapedTitle = str_replace(array('<', '>', '&', '"', "'"), array('&lt;', '&gt;', '&amp;', '&quot;', '&#39;'), $th_title);
        $escapedDesc = str_replace(array('<', '>', '&', '"', "'"), array('&lt;', '&gt;', '&amp;', '&quot;', '&#39;'), $th_desc);

        // I want to have the user ID to insert the record;
        $sql = "SELECT * FROM $userTable WHERE username='" . $_SESSION['username'] . "'";
        $result = $conn->query($sql);
        $userRow = $result->fetch_assoc();
        $userID = $userRow['user_id'];

        $sql = "INSERT INTO $threadTable (thread_title, thread_description, thread_userid, thread_catid) VALUES ('$escapedTitle', '$escapedDesc', $userID , $catID)";
        $insert = $conn->query($sql);

        echo "<div class='alert alert-success alert-dismissible fade show mb-0' role='alert'>
                <strong>Success! </strong> Your thread has been added.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }

    ?>

    <?php
    $catID = $_GET['catid'];
    $sql = "SELECT * FROM $catTable WHERE category_id=$catID ";
    $result = $conn->query($sql);

    $row = $result->fetch_assoc();

    // Jumbotron
    echo "<div class='container-fluid pt-5 pb-2 text-bg-dark'>
            <h1 class='display-5 fw-bold text-center'> Welcome to " . $row['category_name'] . " Forums <button class='btn btn-outline-primary btn-sm' type='button' data-bs-toggle='offcanvas' data-bs-target='#offcanvasExample' aria-controls='offcanvasExample'>Forum Rules</button> </h1>
            <p class='fs-6 fst-italic mt-3 px-4'>" . $row['category_description'] . "</p>

            <div class='offcanvas offcanvas-start' tabindex='-1' id='offcanvasExample' aria-labelledby='offcanvasExampleLabel'>
                <div class='offcanvas-header'>
                    <h5 class='offcanvas-title' id='offcanvasExampleLabel'>Rules of the forum</h5>
                    <button type='button' class='btn-close' data-bs-dismiss='offcanvas' aria-label='Close'></button>
                </div>
                <div class='offcanvas-body'>
                    <ul>
                        <li>Be respectful of other users.</li>
                        <li>Stay on topic.</li>
                        <li>Do not spam or post irrelevant content.</li>
                        <li>Do not post personal information.</li>
                        <li>Do not use offensive language.</li>
                        <li>Use proper grammar and spelling.</li>
                        <li>Use markdown to format your posts.</li>
                        <li>Do not post illegal content.</li>
                        <li>Do not post copyrighted content.</li>
                        <li>Do not bump old threads.</li>
                        <li>Do not necropost.</li>
                        <li>Do not cross-post.</li>
                        <li>Do not troll.</li>
                        <li>Do not flame.</li>
                        <li>Do not argue with moderators.</li>
                        <li>Report any violations of the rules to the moderators.</li>
                    </ul>
                </div>
            </div>
        </div>";

    ?>

    <!-- Starting Discussion  -->
    <?php
    // Session is already started in navbar.php

    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
        echo '<div class="container w-50 my-4">
                <h2 class="mb-3">Start a Discussion : </h2>
                <form action="' . $_SERVER['REQUEST_URI'] . '" method="post">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" placeholder="Problem Title" name="thread_title" required>
                    </div>
                    <div class="mb-3">
                        <label for="desc" class="form-label">Elaborate your concern : </label>
                        <textarea class="form-control" id="desc" rows="3" name="thread_description" placeholder="Problem Description" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-success"> Submit</button>
                </form>
            </div>';
    } else {
        echo '<div class="card container w-75 my-4">
                <div class="card-header">
                    Featured
                </div>
                <div class="card-body">
                    <h5 class="card-title">Want to Post a Ques : </h5>
                    <p class="card-text">You need to login first in order to start a discussion.</p>
                    <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                </div>
            </div>';
    }

    ?>

    <!-- Browse Questions -->
    <div class="container w-75" id="browse">
        <h2 class="my-4">Browse Questions: </h2>
        <?php
        $sql = "SELECT * FROM $threadTable WHERE thread_catid = '" . $_GET['catid'] . "'";
        $result = $conn->query($sql);

        // Question cards
        $num = $result->num_rows;
        if ($num) {
            while ($row = $result->fetch_assoc()) {

                $threadID = $row['thread_id'];
                $threadTitle = $row['thread_title'];
                $threadDesc = $row['thread_description'];
                $threadUserid = $row['thread_userid'];
                $threadCatid = $row['thread_catid'];
                $threadCreated = $row['created_at'];

                $sql2 = "SELECT username FROM $userTable WHERE user_id=" . $threadUserid;
                $result2 = $conn->query($sql2);
                $userRow = $result2->fetch_assoc();
                $username = $userRow['username'];

                echo '<div class="card my-4">
                        <div class="row align-items-center justify-content-around">
                            <div class="col-md-1 px-3">
                                <img src="../images/user_logo.jpg" alt="logo" width="100px">
                            </div>
                            <div class="col-md-11 px-3">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="comments.php?thread_id=' . $threadID . '"> ' . $threadTitle . ' </a></h5>
                                    <p class="card-text">' . $threadDesc . '</p>
                                    <p class="card-text">By: <b>' . $username . '</b><small class="text-body-secondary"> at ' . $threadCreated . '</small></p>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
        } else {
            echo '<div class="card mb-5">
                    <div class="row align-items-center justify-content-around">
                        <div class="col-md-1 px-3">
                            <img src="../images/happy.jpg" alt="logo" width="100px">
                        </div>
                        <div class="col-md-11 px-3">
                            <div class="card-body">
                                <h5 class="card-title"><a href="#" class="text-dark"> No Threads </a></h5>
                                <p class="card-text">Be the 1st one to open a thread</p>
                            </div>
                        </div>
                    </div>
                </div>';
        }

        ?>
    </div>

    <?php include("../components/_footer.php") ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>