<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review</title>
    <?php
    require_once("head.php");
    ?>
</head>
<?php
require_once("koneksi.php");
require_once("header.php");
if (isset($_REQUEST["id"])) {
    $query = $koneksi->prepare("SELECT *, (h.qty*lp.price) as 'total', lp.name as namaProduk from history h, list_product lp, list_user lu where h.product_id=lp.product_id and lu.users_id=h.user_id and h.History_id = ?");
    $query->bind_param("i", $_REQUEST["id"]);
    $query->execute();
    $hasil = $query->get_result()->fetch_assoc();
    if ($_SESSION["active"]["users_id"] != $hasil["users_id"]) {
        header("Location: index.php");
    }
    if ($hasil["rate"] != 0) {
        header("Location: index.php");
    }
    $date = date_create($hasil["date"]);
    if (isset($_REQUEST["btSubmit"])) {
        $queri = $koneksi->prepare("UPDATE history set rate=?, review=? where History_id=?");
        $queri->bind_param("isi", $_REQUEST["star"], $_REQUEST["review"], $_REQUEST["id"]);
        $queri->execute();
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}
?>

<body>
    <div class="container">
        <div class="row" style="width: 100%;">
            <div class="col-3"><img src="<?= $hasil["image"] ?>" class="shadow" alt="" width="100%"></div>
            <div class="col-9">
                <h4><?= $hasil["namaProduk"] ?></h4>
                <h4>Price : Rp. <?= number_format($hasil["price"], 2, ',', '.') ?></h4>
                <h4>Qty : <?= $hasil["qty"] ?></h4>
                <h4>Total : Rp. <?= number_format($hasil["total"], 2, ',', '.') ?></h4>
                <h4>Tanggal Beli : <?= date_format($date, "d F Y") ?></h4>
                <h4>Beri Review : </h4>
                <form action="" method="get">
                    <input type="hidden" name="id" value="<?= $_REQUEST["id"] ?>">
                    <div id="star" class="d-flex mb-2 float-start">
                        <img src="asset/Misc/star.png" alt="">
                        <img src="asset/Misc/stargray.png" alt="">
                        <img src="asset/Misc/stargray.png" alt="">
                        <img src="asset/Misc/stargray.png" alt="">
                        <img src="asset/Misc/stargray.png" alt="">
                    </div>
                    <div class="d-flex mb-2 float-start" style="height:48px;">
                        <input id="qtyStar" name="star" type="number" min="1" max="5" value="1" onchange="ganti()" onKeyDown="return false" class="my-1 mx-2">
                    </div>
                    <div style="clear: both;"></div>
                    <textarea name="review" id="review" cols="60" rows="5"></textarea> <br>
                    <a href="index.php"><button type="button" class="btn btn-danger">Cancel</button></a>
                    <button name="btSubmit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</body>
<?php
require_once("footer.php");
?>

</html>
<script>
    function ganti() {
        $.post("kontroler.php", {
            action: "ganti",
            qty: $("#qtyStar").val()
        }, function(data, status) {
            $("#star").html(data);
        });
    }
</script>