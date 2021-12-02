<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search | Karyaku</title>
    <?php
    require_once("head.php");
    ?>
</head>
<?php
    require_once("koneksi.php");
    require_once("header.php");
    $nama = "%%";
    if (isset($_REQUEST["nama"])) {
        $nama = "%" . $_REQUEST["nama"] . "%";
    }
    if (isset($_REQUEST["harga"])) {
        if ($_REQUEST["harga"]=="asc_harga") {
            $harga = "ASC";
        } else if ($_REQUEST["harga"]=="desc_harga") {
            $harga = "DESC";
        }
    }
    if (isset($_REQUEST["rating"])) {
        if ($_REQUEST["rating"]=="asc_rating") {
            $rating = "ASC";
        } else if ($_REQUEST["rating"]=="desc_rating") {
            $rating = "DESC";
        }
    }
    if (isset($_REQUEST["category"])) {
        $category = $_REQUEST["category"];
    }
    if (isset($_REQUEST["stok"])) {
        if ($_REQUEST["stok"]=="stok_n") {
            $stok = ">";
        }
    }
    //var_dump($harga);
?>

<body style="min-height:100vh; display: flex; flex-direction:column;">
    <div class="container d-flex mt-3 flex-column" style="flex-grow: 1; justify-content:flex-start">
        <form action="#" method="get" style="width:100%"; class="">
            <input type="text" name="nama" class="ms-2" style="width: 40%;" placeholder="Search">
            <select name="category" id="">
                <option style="display:none" disabled selected value> -- Category -- </option>
                <?php
                    $query = $koneksi->prepare("SELECT * FROM list_category");
                    $query->execute();
                    $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
                    foreach($hasil as $key => $value) {
                ?>
                    <option value="<?=$value["category_id"] ?>"><?= $value["nama"] ?></option>
                <?php
                }
                ?>
            </select>
            <select name="harga" id="">
                <option style="display:none" disabled selected value> -- Harga -- </option>
                <option value="asc_harga"> Ascending </option>
                <option value="desc_harga"> Descending </option>
            </select>
            <select name="rating" id="">
                <option style="display:none" disabled selected value> -- Rating -- </option>
                <option value="asc_rating"> Ascending </option>
                <option value="desc_rating"> Descending </option>
            </select>
            <select name="stok" id="">
                <option style="display:none" disabled selected value> -- Stok -- </option>
                <option value="stok_y"> Semua </option>
                <option value="stok_n"> Tersedia </option>
            </select>
            <button class="btn btn-dark"><i class="fa fa-search"></i></button>
        </form>
        <h1 class="mt-3 mb-2" style="margin:auto;">Hasil Pencarian</h1>
        <div style="width: 100%;" class="row">
            <?php
            if (!isset($harga) && !isset($rating) && !isset($category) && !isset($stok)) {
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) from history h where lp.product_id=h.product_id and h.rate!=0) ,'0') as 'rating' FROM list_product lp where lp.name like ? order by rating desc");
                $query->bind_param("s", $nama);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            } else if (isset($harga) && !isset($rating) && !isset($category) && !isset($stok)) {
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) FROM history h WHERE lp.product_id=h.product_id AND h.rate!=0) ,'0') AS 'rating' FROM list_product lp WHERE lp.name LIKE ? ORDER BY lp.price $harga");
                $query->bind_param("s", $nama);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            } else if (!isset($harga) && isset($rating) && !isset($category) && !isset($stok)) {
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) FROM history h WHERE lp.product_id=h.product_id AND h.rate!=0) ,'0') AS 'rating' FROM list_product lp WHERE lp.name LIKE ? ORDER BY rating $rating");
                $query->bind_param("s", $nama);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            } else if (!isset($harga) && !isset($rating) && isset($category) && !isset($stok)) {
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) FROM history h WHERE lp.product_id=h.product_id AND h.rate!=0) ,'0') AS 'rating' FROM list_product lp, product_category pc WHERE lp.name LIKE ? AND pc.product_id = lp.product_id AND pc.category_id = ?");
                $query->bind_param("ss", $nama, $category);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            } else if (!isset($harga) && !isset($rating) && !isset($category) && isset($stok)) {
                // var_dump($stok);
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) FROM history h WHERE lp.product_id=h.product_id AND h.rate!=0) ,'0') AS 'rating' FROM list_product lp WHERE lp.name LIKE ? AND lp.stock $stok 0 order by rating desc");
                $query->bind_param("s", $nama);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            } else if (isset($harga) && isset($rating) && !isset($category) && !isset($stok)) {
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) FROM history h WHERE lp.product_id=h.product_id AND h.rate!=0) ,'0') AS 'rating' FROM list_product lp WHERE lp.name LIKE ? ORDER BY rating $rating, lp.price $harga");
                $query->bind_param("s", $nama);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            } else if (isset($harga) && !isset($rating) && isset($category) && !isset($stok)) {
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) FROM history h WHERE lp.product_id=h.product_id AND h.rate!=0) ,'0') AS 'rating' FROM list_product lp, product_category pc WHERE lp.name LIKE ? AND pc.product_id = lp.product_id AND pc.category_id = ? ORDER BY lp.price $harga");
                $query->bind_param("ss", $nama, $category);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            } else if (isset($harga) && !isset($rating) && !isset($category) && isset($stok)) {
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) FROM history h WHERE lp.product_id=h.product_id AND h.rate!=0) ,'0') AS 'rating' FROM list_product lp WHERE lp.name LIKE ? AND lp.stock $stok 0 order by lp.price $harga");
                $query->bind_param("s", $nama);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            } else if (!isset($harga) && isset($rating) && isset($category) && !isset($stok)) {
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) FROM history h WHERE lp.product_id=h.product_id AND h.rate!=0) ,'0') AS 'rating' FROM list_product lp, product_category pc WHERE lp.name LIKE ? AND pc.product_id = lp.product_id AND pc.category_id = ? ORDER BY rating $rating");
                $query->bind_param("ss", $nama, $category);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            } else if (!isset($harga) && isset($rating) && !isset($category) && isset($stok)) {
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) FROM history h WHERE lp.product_id=h.product_id AND h.rate!=0) ,'0') AS 'rating' FROM list_product lp WHERE lp.name LIKE ? AND lp.stock $stok 0 ORDER BY rating $rating");
                $query->bind_param("ss", $nama, $category);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            } else if (!isset($harga) && !isset($rating) && isset($category) && isset($stok)) {
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) FROM history h WHERE lp.product_id=h.product_id AND h.rate!=0) ,'0') AS 'rating' FROM list_product lp, product_category pc WHERE lp.name LIKE ? AND pc.product_id = lp.product_id AND pc.category_id = ? AND lp.stock $stok 0");
                $query->bind_param("ss", $nama, $category);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            } else if (isset($harga) && isset($rating) && isset($category) && !isset($stok)) {
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) FROM history h WHERE lp.product_id=h.product_id AND h.rate!=0) ,'0') AS 'rating' FROM list_product lp, product_category pc WHERE lp.name LIKE ? AND pc.product_id = lp.product_id AND pc.category_id = ? ORDER BY rating $rating, lp.price $harga");
                $query->bind_param("ss", $nama, $category);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            } else if (isset($harga) && !isset($rating) && isset($category) && isset($stok)) {
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) FROM history h WHERE lp.product_id=h.product_id AND h.rate!=0) ,'0') AS 'rating' FROM list_product lp, product_category pc WHERE lp.name LIKE ? AND pc.product_id = lp.product_id AND pc.category_id = ? AND lp.stock $stok 0 ORDER BY lp.price $harga");
                $query->bind_param("ss", $nama, $category);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            } else if (isset($harga) && isset($rating) && !isset($category) && isset($stok)) {
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) FROM history h WHERE lp.product_id=h.product_id AND h.rate!=0) ,'0') AS 'rating' FROM list_product lp WHERE lp.name LIKE ? AND lp.stock $stok 0 ORDER BY rating $rating, lp.price $harga");
                $query->bind_param("s", $nama);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            } else if (!isset($harga) && isset($rating) && isset($category) && isset($stok)) {
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) FROM history h WHERE lp.product_id=h.product_id AND h.rate!=0) ,'0') AS 'rating' FROM list_product lp, product_category pc WHERE lp.name LIKE ? AND pc.product_id = lp.product_id AND pc.category_id = ? AND lp.stock $stok 0 ORDER BY rating $rating");
                $query->bind_param("ss", $nama, $category);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            } else {
                $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) FROM history h WHERE lp.product_id=h.product_id AND h.rate!=0) ,'0') AS 'rating' FROM list_product lp, product_category pc WHERE lp.name LIKE ? AND pc.product_id = lp.product_id AND pc.category_id = ? AND lp.stock $stok 0 ORDER BY rating $rating, lp.price $harga");
                $query->bind_param("ss", $nama, $category);
                $query->execute();
                $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);
            }
            
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
                            <?php if ($value["stock"]=="0") {
                                echo "<p class='float-end mx-2 text-danger'>HABIS</p>";
                            }
                            ?>
                        </div>
                    </div>
                </a>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
        require_once("footer.php");
    ?>
</body>

</html>