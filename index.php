<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    include("components/_database.php");
    include("components/_navbar.php");
    ?>

    <!-- Caraousel -->
    <div id="carouselExampleDark" class="carousel carousel-dark slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="2000" style="height: 500px;">
                <img src="images/coding_1.webp" class="d-block w-100" alt="..." style="height: 500px;">
                <div class="carousel-caption d-none d-md-block text-light">
                    <h5>Unlocking the Gates of Logic: Where Creativity Meets Precision</h5>
                    <p>Coding is a blend of creativity and precision, where logical thinking and problem-solving skills reign supreme.</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="2000" style="height: 500px;">
                <img src="images/coding_2.jpg" class="d-block w-100" alt="..." style="height: 500px;">
                <div class="carousel-caption d-none d-md-block text-light">
                    <h5>Debugging Reality, One Line at a Time.</h5>
                    <p>Coders are akin to digital detectives, meticulously debugging and solving real-world problems through lines of code.</p>
                </div>
            </div>
            <div class="carousel-item" data-bs-interval="2000" style="height: 500;">
                <img src="images/coding_3.jpg" class="d-block w-100" alt="..." style="height: 500px;">
                <div class="carousel-caption d-none d-md-block text-light">
                    <h5>Coding: Where Imagination Meets Execution</h5>
                    <p>Coders are architects of the digital realm, bringing to life the imaginative visions through precise execution of code.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container my-3" id="browse">
        <h1>Browse Categories :</h1>
        <!-- Cards -->
        <div class="row">
            <!-- Use a for loop to iterate through the categories which are present in DB -->
            <?php
            $sql = "SELECT * FROM $catTable";
            $result = $conn->query($sql);
            $num = $result->num_rows;

            while ($row = $result->fetch_assoc()) {

                $catID = $row['category_id'];
                $catName = $row['category_name'];
                $catDesc = $row['category_description'];

                if($catName=='Javascript' || $catName=='React'){
                    $img = '.png';
                }
                else if($catName=='C_Sharp' || $catName=='C++'){
                    $img = '.jpeg';
                }
                else{
                    $img = '.jpg';
                }

                echo "<div class='col-md-4 my-3'>
                        <div class='card' style='width: 23rem;'>
                            <img src='images/categories/". $catName.$img ."' class='card-img-top' alt='cat1' style='height: 150px;'>
                            <div class='card-body'>
                                <h5 class='card-title'><a href='src/threads.php?catid=".$catID."'>". $catName. "</a></h5>
                                <p class='card-text'>". substr($catDesc,0,250) ."...</p>
                                <a href='src/threads.php?catid=".$catID."' class='btn btn-primary'>Explore >></a>
                            </div>
                        </div>
                    </div>";
            }

            ?>
        </div>
    </div>

    <?php include("components/_footer.php") ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

