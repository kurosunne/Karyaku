<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | Karyaku</title>
    <?php
    require_once("head.php");
    ?>
</head>
<?php
require_once("koneksi.php");
require_once("header.php");
if (isset($_SESSION["active"])) {
    if ($_SESSION["active"] == "admin") {
        header("Location: index.php");
    }
} else {
    header("Location: login.php");
}

$id = $_SESSION["active"]["users_id"];
?>

<body>
    <div class="modal" id="cartSuccess" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body bg-danger p-0">
                    <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-danger d-flex pt-0 justify-content-center pb-4">
                    <h4 class="text-light">Item Deleted !</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div style="width: 100%;" class="row" id="box">
            <?php
            $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) from history h where lp.product_id=h.product_id and h.rate!=0) ,'0') as 'rating', c.* FROM list_product lp, cart c where lp.product_id=c.product_id and c.user_id=? order by rating desc");
            $query->bind_param("i", $id);
            $query->execute();
            $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);

            foreach ($hasil as $key => $value) {
            ?>
                <div class=" col-xxl-3 col-xl-4 col-lg-6 mb-xl-0 mb-xxl-0 mb-md-5">
                    <a href="detail.php?id=<?= $value["product_id"] ?>&nama=<?= $value["name"] ?>" style="klik text-decoration:none; color:black;">
                        <div style="width: 90%; height:90%" class="shadow d-flex flex-column">
                            <img src="<?= $value["image"] ?>" alt="" width="100%">
                            <div style="height: 50px;" class="mt-0 mb-2">
                                <p class="my-0 ms-1"><?= $value["name"] ?></p>
                            </div>
                            <div class="mt-0 mb-0">
                                <p class="float-start ms-2"><?= $value["qty"] ?></p>
                            </div>
                            <div>
                                <img class="float-start ms-2" src="asset/Misc/star.png" alt="" height="25px">
                                <p class="float-start mx-2"><?= $value["rating"] ?>/5</p>
                                <p class="float-end mx-2">Rp. <?= number_format($value["price"], 2, ',', '.') ?></p>
                            </div>
                        </div>
                    </a>
                    <button class="btn btn-danger mt-2" onclick="removeCart(<?= $value['product_id'] ?>)" style="width: 90%;">Remove</button>
                    <button class="btn btn-primary mt-2" style="width: 90%;">Check Out</button>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>
<script>
    function removeCart(index) {
        $.post("kontroler.php", {
            action: "removeCart",
            item:index
        }, function(data, status) {
            $("#cartSuccess").modal("show");
            $("#box").html(data);
        });
    }
</script>