<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Karyaku</title>
    <?php
        require_once("head.php");
    ?>
</head>
<body>
    <?php
        require_once("header.php");
    ?>

    <div class="container d-flex justify-content-center mt-3">
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel" style="width: 75%; height:40vh; border-radius:10px;">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="5000">
                <img style=" height:40vh; border-radius:10px;" src="asset/Banner/baner1.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                <img style=" height:40vh; border-radius:10px;" src="asset/Banner/baner2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                <img style=" height:40vh; border-radius:10px;" src="asset/Banner/baner3.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</body>
</html>
