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

    <div class="container my-4" id="browse">
        <h2 class="text-center">Search Results for <span class="fst-italic">"<?php echo $_GET['query'] ?>" :</span></h2>

        <?php 
        $query = $_GET['query'];
        // Query for searching a item in Database;
        $sql = "SELECT * FROM $threadTable WHERE thread_title LIKE '%$query%' OR thread_description LIKE '%$query%'";
        $result = $conn->query($sql);
        $num = $result->num_rows;
        if($num){
            while($row = $result->fetch_assoc()){
                $threadID = $row['thread_id'];
                $threadTitle = $row['thread_title'];
                $threadDesc = $row['thread_description'];
                $threadUserid = $row['thread_userid'];
                $threadCatid = $row['thread_catid'];
                $threadCreated = $row['created_at'];

                $sql = "SELECT username FROM $userTable WHERE user_id=" . $threadUserid;
                $result = $conn->query($sql);
                $userRow = $result->fetch_assoc();
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
        }
        else{
            echo '<div class="card mb-5 my-3">
                    <div class="row align-items-center justify-content-around">
                        <div class="col-md-1 px-3">
                            <img src="../images/happy.jpg" alt="logo" width="100px">
                        </div>
                        <div class="col-md-11 px-3">
                            <div class="card-body">
                                <h5 class="card-title"><a href="#" class="text-dark">No Results Found</a></h5>
                                <p class="card-text">Please try for another search term</p>
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