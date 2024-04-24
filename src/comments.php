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

    <!-- Showing the alert -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $comment = $_POST['comment_text'];
        $threadID = $_GET['thread_id'];

        // To prevent the XSS attack from the user inserting into Input area
        $escapedComment = str_replace(array('<', '>', '&', '"', "'"), array('&lt;', '&gt;', '&amp;', '&quot;', '&#39;'), $comment);

        $sql = "SELECT * FROM $userTable WHERE username='" . $_SESSION['username'] . "'";
        $result = $conn->query($sql);
        $userRow = $result->fetch_assoc();
        $userID = $userRow['user_id'];

        $sql = "INSERT INTO $commentTable (comment, thread_id, comment_by) VALUES ('$escapedComment', $threadID , $userID);";
        $insert = $conn->query($sql);

        echo "<div class='alert alert-success alert-dismissible fade show mb-0' role='alert'>
                <strong>Success! </strong> Your has been added.
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    ?>

    <!-- Jumbotron -->
    <?php
    $threadID = $_GET['thread_id'];
    $sql = "SELECT * FROM $threadTable WHERE thread_id=$threadID";
    $result = $conn->query($sql);
    $threadRow = $result->fetch_assoc();

    $sql = "SELECT username FROM $userTable WHERE user_id='" . $threadRow['thread_userid'] . "'";
    $result = $conn->query($sql);
    $userRow = $result->fetch_assoc();

    echo "<div class='container w-75 pt-5 pb-2'>
            <h1 class='display-5 fw-bold'>" . $threadRow['thread_title'] . "</h1>
            <p class='fs-6 fst-italic mt-3'>" . $threadRow['thread_description'] . "</p>
            <hr>
            <p>Posted By: <b>" . $userRow['username'] . "</b></p>
        </div>";
    ?>

    <!-- Posting comment  -->
    <?php
    // Session is already started in navbar.php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<div class="container w-75 my-4">
        <h2 class="mb-3">Post Comment </h2>
        <form action="'. $_SERVER['REQUEST_URI'] .'" method="post">
            <div class="mb-3">
                <label for="desc" class="form-label">Give your solution here</label>
                <textarea class="form-control" id="desc" rows="3" name="comment_text" placeholder="Comment..." required></textarea>
            </div>
            <button type="submit" class="btn btn-outline-success">Post</button>
        </form>
    </div>';
    }
    else{
        echo '<div class="card container w-75 my-4">
                <div class="card-header">
                    Featured
                </div>
                <div class="card-body">
                    <h5 class="card-title">Want to Post Comment : </h5>
                    <p class="card-text">You need to login first in order to start a discussion.</p>
                    <button class="btn btn-outline-danger" type="button" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
                </div>
            </div>';
    }
    ?>

    

    <!-- Browse Questions -->
    <div class="container w-75" id="browse">
        <h2 class="my-4"> Comments: </h2>
        <?php
        $threadID = $_GET['thread_id'];
        $sql = "SELECT * FROM $commentTable WHERE thread_id=$threadID";
        $comments = $conn->query($sql);
        $num = $comments->num_rows;

        if ($num) {
            while ($row = $comments->fetch_assoc()) {

                $comment = $row['comment'];
                $createdAt = $row['created_at'];
                $userID = $row['comment_by'];

                $sql = "SELECT username FROM $userTable WHERE user_id=" . $userID;
                $result = $conn->query($sql);
                $userRow = $result->fetch_assoc();
                $username = $userRow['username'];

                echo '<div class="card mb-3">
                        <div class="row align-items-center justify-content-around">
                            <div class="col-md-1 px-3">
                                <img src="../images/user_logo.jpg" alt="logo" width="100px">
                            </div>
                            <div class="col-md-11 px-3">
                                <div class="card-body">
                                    <p class="card-title">'. $comment .'</p>
                                    <p class="card-title">By: <b>' . $username . '</b> at <small class="text-body-secondary">'. $createdAt .' </small></p>
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
                                <h5 class="card-title"><a href="#" class="text-dark"> No Comments </a></h5>
                                <p class="card-text">Be the 1st one to comment on a thread</p>
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