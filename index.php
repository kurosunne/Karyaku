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

<?php
require_once("koneksi.php");
require_once("header.php");
if (isset($_SESSION["index"])) {
    unset($_SESSION["index"]);
}
?>

<body>
    <div class="container d-flex justify-content-center mt-3 flex-column">
        <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel" style="width: 95%; margin:auto; height:400px; border-radius:10px;">
            <div class="carousel-inner">
                <div class="carousel-item active" data-bs-interval="5000">
                    <img style=" height:400px; border-radius:10px;" src="asset/Banner/baner1.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img style=" height:400px; border-radius:10px;" src="asset/Banner/baner2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <img style=" height:400px; border-radius:10px;" src="asset/Banner/baner3.jpg" class="d-block w-100" alt="...">
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
        <!--List Item-->
        <h1 class="mt-3 mb-2" style="margin:auto;">Rekomendasi Produk</h1>
        <div style="width: 100%;" class="row">
            <?php
            $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) from history h where lp.product_id=h.product_id and h.rate!=0) ,'0') as 'rating' FROM list_product lp order by rating desc");
            $query->execute();
            $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);

            foreach ($hasil as $key => $value) {
            ?>
                <a href="detail.php?id=<?= $value["product_id"] ?>&nama=<?= $value["name"] ?>" class="klik col-xxl-3 col-xl-4 col-lg-6 mb-xl-0 mb-xxl-0 mb-md-5" style=" text-decoration:none; color:black;">
                    <div style="width: 100%; height:90%" class="shadow d-flex flex-column">
                        <img src="<?= $value["image"] ?>" alt="" width="100%">
                        <div style="height: 100px;" class="mt-0 mb-2">
                            <p class="my-0 ms-1"><?= $value["name"] ?></p>
                        </div>
                        <div>
                            <img class="float-start ms-2" src="asset/Misc/star.png" alt="" height="25px">
                            <p class="float-start mx-2"><?= $value["rating"] ?>/5</p>
                            <p class="float-end mx-2">Rp. <?= number_format($value["price"], 2, ',', '.') ?></p>
                        </div>
                    </div>
                </a>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>