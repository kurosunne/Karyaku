<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Whistlist | Karyaku</title>
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

<body style="min-height:100vh; display: flex; flex-direction:column;">
    <div class="modal" id="wishlistSuccess" tabindex="-1">
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
    <div class="container" style="flex-grow: 1;">
        <div style="width: 100%;" class="row" id="box">
            <?php
            $query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) from history h where lp.product_id=h.product_id and h.rate!=0) ,'0') as 'rating' FROM list_product lp, wishlist w where lp.product_id=w.product_id and w.user_id=? order by rating desc");
            $query->bind_param("i", $id);
            $query->execute();
            $hasil = $query->get_result()->fetch_all(MYSQLI_ASSOC);

            foreach ($hasil as $key => $value) {
                $diskon = $koneksi->prepare("SELECT * from discount where product_id=?");
                $diskon->bind_param("i", $value["product_id"]);
                $diskon->execute();
                $resdiskon = $diskon->get_result()->fetch_all(MYSQLI_ASSOC);
            ?>
                <div class=" col-xxl-3 col-xl-4 col-lg-6 mb-xl-0 mb-xxl-0 mb-md-5">
                    <a href="detail.php?id=<?= $value["product_id"] ?>&nama=<?= $value["name"] ?>" class="klik" style="text-decoration:none; color:black;">
                        <div style="width: 90%;" class="shadow d-flex flex-column">
                            <img src="<?= $value["image"] ?>" alt="" width="100%">
                            <div style="height: 100px;" class="mt-0 mb-2">
                                <p class="my-0 ms-1"><?= $value["name"] ?></p>
                            </div>
                            <div>
                                <?= count($resdiskon) > 0 ? "<p class='float-end mx-2 mt-0 my-0' style='color:grey; text-decoration:line-through; ?>;''>Rp. " . number_format($value["price"], 2, ',', '.') . "</p>" : '' ?>
                                <div style="clear: both;"></div>
                                <img class="float-start ms-2" src="asset/Misc/star.png" alt="" height="25px">
                                <p class="float-start mx-2"><?= $value["rating"] ?>/5</p>
                                <?php
                                if (count($resdiskon) > 0) {
                                    $tempHarga = $value["price"] - ($resdiskon[0]["discount_value"] / 100 * $value["price"]);
                                }
                                ?>
                                <?= count($resdiskon) > 0 ? "<p class='float-end mx-2 mb-0'>Rp. " . number_format($tempHarga, 2, ',', '.') . "</p>" : '<p class="float-end mx-2" >Rp. ' . number_format($value["price"], 2, ',', '.') . '</p>' ?>
                            </div>
                        </div>
                    </a>
                    <button class="btn btn-danger mt-3" onclick="removeWishlist(<?= $value['product_id'] ?>)" style="width: 90%;">Remove</button>
                </div>
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
<script>
    function removeWishlist(index) {
        $.post("kontroler.php", {
            action: "removeWishlist",
            item: index
        }, function(data, status) {
            $("#wishlistSuccess").modal("show");
            $("#box").html(data);
        });
    }
</script>