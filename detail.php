<!DOCTYPE html>
<?php
$id = $_REQUEST["id"];
$nama = $_REQUEST["nama"];

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nama ?> | Karyaku</title>
    <?php
    require_once("head.php");
    ?>
</head>
<?php
require_once("koneksi.php");
require_once("header.php");
$query = $koneksi->prepare("SELECT lp.*, NVL((SELECT CAST(SUM(h.rate)/count(h.rate) as INT) from history h where lp.product_id=h.product_id and h.rate!=0) ,'0') as 'rating' FROM list_product lp where lp.product_id=?");
$query->bind_param("i", $id);
$query->execute();
$hasil = $query->get_result()->fetch_assoc();

$q2 = $koneksi->prepare("SELECT count(*) as 'jumlah' FROM history where product_id=?");
$q2->bind_param("i", $hasil["product_id"]);
$q2->execute();
$hh = $q2->get_result()->fetch_assoc();

$diskon = $koneksi->prepare("SELECT * from discount where product_id=?");
$diskon->bind_param("i",$id);
$diskon->execute();
$resdiskon = $diskon->get_result()->fetch_all(MYSQLI_ASSOC);

$tempHarga = $hasil["price"];
?>

<body>
    <!--MODAL ADD WISHLIST SUCCESS -->
    <div class="modal" id="wishlistSuccess" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body bg-success p-0">
                    <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-success d-flex pt-0 justify-content-center pb-4">
                    <h4 class="text-light">Wishlist Berhasil !</h4>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL ADD CART SUCCESS -->
    <div class="modal" id="cartSuccess" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body bg-success p-0">
                    <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-success d-flex pt-0 justify-content-center pb-4">
                    <h4 class="text-light">Cart Berhasil !</h4>
                </div>
            </div>
        </div>
    </div>
    <!--MODAL USER HASNT LOGIN YET -->
    <div class="modal" id="noLogin" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body bg-danger p-0">
                    <button type="button" class="btn-close float-end m-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-danger d-flex pt-0 justify-content-center pb-4">
                    <div class="row"><h4 class="text-light">Belum Login !</h4></div>
                </div>
                <div class="modal-footer bg-danger d-flex p-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-danger">Login</button>
                </div>
            </div>
        </div>
    </div>
    <div class="container d-flex justify-content-center mt-3 flex-column">
        <div class="row" style="height: 500px;">
            <div class="col-4"><img class="shadow" src="<?= $hasil["image"] ?>" alt="" width="90%"></div>
            <div class="col-5">
                <h3><?= $hasil["name"] ?></h3>
                <img class="float-start ms-2" src="asset/Misc/star.png" alt="" height="25px">
                <p class="float-start mx-2"><?= $hasil["rating"] ?>/5 <span class="text-secondary"> (<?= $hh["jumlah"] ?> review) </span></p>
                <div style="clear: both;"></div>
                <h5 style="color: <?= count($resdiskon)==0?"black":"gray" ?>; text-decoration:<?= count($resdiskon)==0?"none":"line-through" ?>;" >Rp. <?= number_format($tempHarga, 2, ',', '.') ?></h5>
                <?php
                    if (count($resdiskon)>0) {
                        $tempHarga = $hasil["price"] - ($resdiskon[0]["discount_value"] / 100 * $hasil["price"]);
                    }
                ?>
                <?= count($resdiskon)>0?"<h5>Rp. " .number_format($tempHarga, 2, ',', '.')."</h5>":"" ?>
                <p style="white-space: pre-line"><?= $hasil["description"] ?></p>
            </div>
            <div class="col-3">
                <!--INPUT QUANTITY, WISHLIST, CART BUTTONS -->
                <div style="width:95%; padding:10px; height:280px; border-radius:10px;" class="shadow">
                    Quantity: <input type="number" onchange="append()" value="1" class="mx-2" style="width: 50px;" id="productQTY" min="1" max="<?=$hasil['stock']?>" onKeyDown="return false">
                    <p class="text-secondary">Stock : <?= $hasil["stock"] ?></p>
                    <input type="hidden" value="<?= $tempHarga ?>" id="productPrice">
                    <h5>Subtotal : </h5>
                    <h5 class="mt-0" id="subtotal">Rp. <?= number_format($tempHarga, 2, ',', '.') ?></h5>
                    <button class="btn btn-primary mt-3" onclick="addWishlist(<?=$hasil['product_id']?>)" style="width: 100%;">Add to Wishlist</button>
                    <button class="btn btn-success mt-2" onclick="addCart(<?=$hasil['product_id']?>)" style="width: 100%;">Add to Cart</button>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            $review = $koneksi->prepare("SELECT * from history h, list_user u where rate!=? and product_id=? and u.users_id=h.user_id");
            $nol = 0;
            $review->bind_param("ii", $nol, $id);
            $review->execute();
            $preview = $review->get_result()->fetch_all(MYSQLI_ASSOC);

            foreach ($preview as $key => $value) {
            ?>
                <div class="col-9 mt-1 shadow">
                    <div class="float-start">
                        <img src="asset/Misc/profil.jpg" alt="" class="mt-3" height="70px">
                        <p class="mb-0"><?= $value["name"] ?></p>
                        <p class="my-0"><?= $value["date"] ?></p>
                    </div>
                    <div class="float-start">
                        <?php
                        for ($i = 0; $i < $value["rate"]; $i++) {
                        ?>
                            <img class="float-start ms-2 mt-2" src="asset/Misc/star.png" alt="" height="25px">
                        <?php
                        }
                        ?>
                        <?php
                        for ($i = 0; $i < 5-$value["rate"]; $i++) {
                        ?>
                            <img class="float-start ms-2 mt-2" src="asset/Misc/starGray.png" alt="" height="25px">
                        <?php
                        }
                        ?>
                        <div style="clear: both;"></div>
                        <p class="mt-2 ms-2"><?=$value["review"]?></p>
                    </div>
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
    function append() {
        $.post("kontroler.php", {
            action: "append",
            price: $("#productPrice").val(),
            qty: $("#productQTY").val()
        }, function(data, status) {
            $("#subtotal").html(data);
        });
    }

    //ADD WISHLIST (MUST LOGIN FIRST)
    function addWishlist(index){
        <?php
            //CHECK LOGIN USER
            if (isset($_SESSION["active"])) {
                ?>
                    //ADD WISHLIST
                    $.post("kontroler.php", {
                        action: "addWishlist",
                        item:index
                    }, function(data, status) {
                        $("#wishlistSuccess").modal("show");
                    });
                <?php
            } else {
                ?>
                //USER HASNT LOGIN YET
                    window.location.replace("login.php");
                <?php
            }
        ?>
        
    }

    //ADD CART (USER MUST LOGIN FIRST)
    function addCart(index){
        var qty = $("#productQTY").val();
        //alert(qty);
        <?php
            if (isset($_SESSION["active"])) {
                ?>
                    //ADD CART
                    $.post("kontroler.php", {
                        action: "addCart",
                        item:index,
                        quantity : qty
                    }, function(data, status) {
                        $("#cartSuccess").modal("show");
                    });
                <?php
            } else {
                ?>
                //USER HASNT LOGIN YET
                    window.location.replace("login.php");
                <?php
            }
        ?>
    }
</script>